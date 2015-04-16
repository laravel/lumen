<?php

class ExampleTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $response = $this->call('GET', '/');

        $this->assertResponseOk();
        $this->assertEquals('Hello World', $response->getContent());
    }

}
