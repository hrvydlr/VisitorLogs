<?php

//PAGE NAME
if (!function_exists("page_name")) {
    function page_name($name)
    {
        $path = explode('/', Request::path());
        $menu_name = strtolower($path[0]);
        $main = str_replace("_", " ", $menu_name);
        $sub  = isset($path[1]) && $path[1] ? strtolower($path[1]) : '';
        $page_title = $main;

        if ($main == "home") $page_title = "Dashboard";
        else if ($main == "user") $page_title = "Users";

        $menu = [
            'menu' => $menu_name,
            'main' => $main,
            'sub' => $sub,
            'page_title' => $page_title
        ];

        return $menu[$name];
    }
}

