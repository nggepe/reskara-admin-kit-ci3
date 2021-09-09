<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Auth_Controller
{
    public function index()
    {
        $menu = $this->get_menu();
        // exit(json_encode($menu));
        $this->load->view('template/layout', ["menu" => $menu]);
    }
}
