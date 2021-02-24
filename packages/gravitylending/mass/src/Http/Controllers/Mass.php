<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Controllers;


class Mass
{

    public function store ($data) {
        dd('store', $data);
    }

    public function index()
    {
        dd('index');
    }

    public function show ($id) {
        dd('show ' . $id);
    }

    public function update ($id, $data) {
        dd('update', $data);
    }

    public function destroy ($id) {
        dd('destroy ' . $id);
    }
}
