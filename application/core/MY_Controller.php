<?php

class Res_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function json_response($body, $header = 200)
    {
        $this->output->set_status_header($header)->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
    }
}

class Auth_Controller extends Res_Controller
{
    function __construct()
    {
        parent::__construct();
    }
}
