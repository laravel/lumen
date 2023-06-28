<?php
/**
 * 个人中心的
 */

namespace App\Http\Controllers;

use App\Http\Util;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PersonalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $token;
    private $user_id;

    public function __construct(Request $request)
    {
        $token = $request->header('token', '');
        if (empty($token)) {
            $this->token = '';
        }
        $token_result = UserServices::checkJwt($token);
        if ($token_result['code'] == 200) {
            $token_result_new = json_decode(json_encode($token_result['data']->data), true);;
            $this->token = $token_result_new;
            $this->user_id = $token_result_new['user_id'] ?? '';
        } else {
            $this->token = '';
            $this->user_id = 0;
        }

    }


    /**
     * 个人中心
     */
    public function personalInfo()
    {
        if (empty($this->token)) {
            return $this->failed('Login has expired, please login again', -1);
        }

        $data = [
            'user_id' => $this->user_id,
            'account_type' => $this->token['account_type'],
            'account_start_time' => !empty($this->token['account_start_time']) ? date("Y-m-d", $this->token['account_start_time']) : '-',
            'account_end_time' => $this->token['account_end_time'] ? date("Y-m-d", $this->token['account_end_time']) : '-',
        ];

        return $this->success($data);
    }

    /**
     * 账单中心
     */
    public function billInfo()
    {
        if (empty($this->token)) {
            return $this->failed('Login has expired, please login again', -1);
        }

        $result = UserServices::getBillList($this->user_id);

        return $this->success($result);
    }

    /**
     * 导入操作
     */
    public function importData(Request $request)
    {
        if (empty($this->token)) {
            return $this->failed('Login has expired, please log in again', -1);
        }

        //获取表单上传文件
        $file = $request->file('myfile');
        $allowExt = ["csv", "xls", "xlsx"];
        $ext = $file->getClientOriginalExtension();
        if (!in_array($ext, $allowExt)) {
            return $this->failed('Your file extension is error, please choose .xlsx .xls .csv file again.', -1);
        }

        // 拿到用户导入的资格
        $user_level = UserServices::getUserLevel($this->user_id);
        $user_expire_time = UserServices::getUserExpireTime($this->user_id);
        $current_time = date("Y-m-d H:i:s");
        if ($user_level > 0 && $current_time >= $user_expire_time) {
            return $this->failed('User account level has expired, please re-purchase.', -1);
        }

        $tmp_path = 'storage/excel_temp/' . date('Ym');
        $dir_path = public_path($tmp_path);
        if (!is_dir($dir_path) && !mkdir($dir_path, 0777, true)) {
            return $this->failed('upload file dir is error. please Contact our IT.', -1);
        }
        //如果目标目录没有写入权限
        if (is_dir($dir_path) && !is_writable($dir_path)) {
            return $this->failed('upload file dir is error. please Contact our IT.', -1);
        }
        $no_ext_file_name = $this->user_id . uniqid() . '_' . dechex(microtime(true));
        $file_name = $no_ext_file_name . '.' . $ext;
        $path = $file->move($tmp_path, $file_name);
        $web_path = '/' . $path->getPath() . '/' . $file_name;

        // 开始处理excel 数据
        // 获取excel的总数据
        $file_ext_map = [
            'csv' => 'Csv',
            'xlsx' => 'Xlsx',
            'xls' => 'Xls',
        ];
        $reader = IOFactory::createReader($file_ext_map[$ext]);
        $reader->setReadDataOnly(true);
//        echo $dir_path . $file_name;
        $spreadsheet = $reader->load($dir_path . '/' . $file_name);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow(); // 总行数
        if ($user_level == 0 && $highestRow > env('LIMIT_IMPORT_NUMBER')) {
            return $this->failed('Free account type just upload 20 rows number. please upgrade account type.', -1);
        }
        $lines = $highestRow - 1;

        if ($lines <= 0) {
            return $this->failed('Excel file is empty. please choose .xlsx .xls .csv file again.', -1);
        }

        // 开始处理excel数据
        $vcardINF = "";
        for ($row = 2; $row <= $highestRow; ++$row) {
            $mobile = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); //电话
            if (empty($mobile)) {
                continue;
            }

            $vcardINF .= "BEGIN:VCARD" . PHP_EOL;
            $vcardINF .= "VERSION:3.0" . PHP_EOL;
            $name = $worksheet->getCellByColumnAndRow(1, $row)->getValue(); // 姓名
            $vcardINF .= 'FN:' . htmlspecialchars(trim($name)) . PHP_EOL;

            if (!empty($mobile)) {
                $mobile = str_replace('-', '', $mobile);
                $mobile = str_replace('-', '', $mobile);
                $vcardINF .= 'TEL;TYPE#WORK,VOICE:' . htmlspecialchars(trim($mobile)) . PHP_EOL;
            }

            $email = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); // 邮箱
            if (!empty($email)) {
                $vcardINF .= 'EMAIL;PREF;INTERNET:' . htmlspecialchars(trim($email)) . PHP_EOL;
            }

            $company = $worksheet->getCellByColumnAndRow(4, $row)->getValue(); // 公司
            if (!empty($company)) {
                $vcardINF .= 'ORG:' . htmlspecialchars(trim($company)) . PHP_EOL;
            }

            $work_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue(); // 职位
            if (!empty($work_name)) {
                $vcardINF .= 'TITLE:' . htmlspecialchars(trim($work_name)) . PHP_EOL;
            }

            $vcardINF .= 'END:VCARD' . PHP_EOL;
        }

        $tmp_path = 'storage/phone_vcf/' . date('Ym');
        $dir_path = public_path($tmp_path);
        if (!is_dir($dir_path) && !mkdir($dir_path, 0777, true)) {
            return $this->failed('Get phone file dir is error. please Contact our IT.', -1);
        }
        $vcf_file_name = $no_ext_file_name . '.vcf';
//        echo $dir_path . '/' . $vcf_file_name . '<<<<';
        file_put_contents($dir_path . '/' . $vcf_file_name, $vcardINF);

        $url = 'http://www.gatherdeals.org/' . $tmp_path . '/' . $vcf_file_name;

        $tmp_path = 'storage/qrcode/' . date('Ym');
        $dir_path = public_path($tmp_path);
        if (!is_dir($dir_path) && !mkdir($dir_path, 0777, true)) {
            return $this->failed('Get qrcode file dir is error. please Contact our IT.', -1);
        }
        $qrcode_file_name = $no_ext_file_name . '.png';

        $qrcodeResult = QrCode::format('png')->size(300)->margin(10)->generate($url, $dir_path . '/' . $qrcode_file_name);
        $imageUrl = 'http://www.gatherdeals.org/' . $tmp_path . '/' . $qrcode_file_name;
        // 上传阿里云地址
        // https://alphasnow.github.io/aliyun-oss-laravel/
//        Storage::disk("oss")->putFile("dir/path", "/local/path/file.txt");

        return $this->success(['qrcode_url' => $imageUrl], 'Please scan qrcode to download file and open it.');
    }

    /**
     * 支付
     */
    public function pay(Request $request)
    {
        if (empty($this->token)) {
            return $this->failed('Login has expired, please log in again', -1);
        }

        $pay_type = $request->post('pay_type', 0); // 0: free 1: 1 month 6: 6 month
        if ($pay_type == 0) {
            return $this->success([], 'Congratulations.');
        }


        // 金额配置
        $amount_list = [
            1 => '19',
            6 => '59'
        ];

        $pay_amount = $amount_list[$pay_type];
        $payment_id = Util::randChar();

        $order_request = new OrdersCreateRequest();
        $order_request->prefer('return=representation');
        $order_request->body = [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => 'https://www.gatherdeals.org/pay_success.html',
                'cancel_url' => 'https://www.gatherdeals.org/pay_error.html'
            ],
            'purchase_units' => [
                [
                    "reference_id" => $payment_id,
                    "description" => "Purchase {$pay_type}-month VIP membership service",
                    "amount" => [
                        "value" => $pay_amount,
                        "currency_code" => 'USD',
                        'breakdown' => [
                            'item_total' =>
                                [
                                    'currency_code' => 'USD',
                                    'value' => $pay_amount,
                                ],
                        ]
                    ],
                    'items' => [
                        [
                            'name' => "{$pay_type}-month",
                            'description' => "{$pay_type}-month VIP membership",
                            'unit_amount' =>
                                [
                                    'currency_code' => 'USD',
                                    'value' => $pay_amount,
                                ],
                            'quantity' => '1',
                        ],
                    ],
                ]
            ]
        ];

        try {

            $mode = env('PAYPAL_MODE');

            if ($mode == 'live') {
                $client = new PayPalHttpClient(new ProductionEnvironment(env('PAYPEL_CLIENT_ID'), env('PAYPEL_SECRET')));
            } else {
                $client = new PayPalHttpClient(new SandboxEnvironment(env('PAYPEL_UAT_CLIENT_ID'), env('PAYPEL_UAT_SECRET')));
            }
            $response = $client->execute($order_request);

            return response()->json($response, 200);

        } catch (\Exception $ex) {
            return response()->json(['message' => 'Something went wrong. Please try again.'], $ex->statusCode);
        }
    }

    public function payReturn(Request $request)
    {
        $order_request = new OrdersCaptureRequest($request->orderID);

        try {
            $mode = env('PAYPAL_MODE');

            if ($mode == 'live') {
                $client = new PayPalHttpClient(new ProductionEnvironment(env('PAYPEL_CLIENT_ID'), env('PAYPEL_SECRET')));
            } else {
                $client = new PayPalHttpClient(new SandboxEnvironment(env('PAYPEL_UAT_CLIENT_ID'), env('PAYPEL_UAT_SECRET')));
            }

            $response = $client->execute($order_request);

            if ($response->result->status == 'COMPLETED') {
                // 写入订单表
                return response()->json(['response' => $response], 200);
            }
            return response()->json(['message' => 'Something went wrong'], 500);

        } catch (\Exception $ex) {
            return response()->json(['message' => 'Something went wrong'], $ex->statusCode);
        }
    }
}
