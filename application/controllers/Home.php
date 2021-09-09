<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Auth_Controller
{
    public function index()
    {
        $menu = $this->get_menu();
        $sidebar = $this->get_sidebarmenu($menu);
        $this->load->view('template/layout', ["menu" => $sidebar]);
    }

    private function get_sidebarmenu($menu): string
    {
        $output = "<ul>";

        foreach ($menu as $key => $value) {
            $class = "";
            $child = "";
            if (count($value->child) > 0) {
                $class = "class='has-child'";
                $child .= $this->get_sidebarmenu($value->child);
            }

            $href = "href='" . $value->path . "'";

            $a = "<a $class $href >" . $value->icon . "<span>" . $value->name . "</span></a>";

            $li = "<li>";
            $li .= $a;
            $li .= $child;
            $li .= "</li>";
            $output .= $li;
        }

        $output .= "</ul>";

        return $output;
    }
}
