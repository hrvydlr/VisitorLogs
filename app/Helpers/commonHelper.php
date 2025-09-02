<?php

use App\Models\User;
use App\Models\VisitorType;
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


if (!function_exists("create_action")) {
    function create_action($id, $delete, $edit, $view = "")
    {

        $btnView  = $view ? sprintf('<a class="btn-view" title="View" role="button" data-id="%s"><i class="bi bi-eye"></i></a>', $id) : '';
        $btnEdit  = $edit ? sprintf('<li><a class="dropdown-item btn-edit" data-id="%s"><i class="bi bi-pencil-square me-2"></i>%s</a></li>', $id, $edit) : '';

        $btnDelete = $delete ? sprintf('<li><hr class="dropdown-divider"></li><li><a class="dropdown-item btn-delete" data-id="%s" data-details="%s"><i class="bi bi-trash me-2"></i>Delete</a></li>', $id, $delete) : '';

        $button  = sprintf('<div class="group-action">%s<div class="btn-group" role="group">', $btnView);
        $button .= '<button type="button" title="Dropdown" id="btn-actions" data-bs-toggle="dropdown" aria-expanded="false" class="border-0 bg-transparent p-0">
                    <i class="bi bi-three-dots-vertical other-link"></i>
                    </button>';
        $button .= sprintf('<ul class="dropdown-menu" aria-labelledby="btn-actions">%s%s</ul></div></div>', $btnEdit, $btnDelete);

        return $button;
    }
}



if(!function_exists("name")){
    function name($id){
        $user = User::find($id);
        return $user ? $user->first_name .' ' . $user->last_name : 'Unknown User';
    }
}

if(!function_exists("visitor_types")){
    function visitor_types(){
        return VisitorType::withoutTrashed()->get();
    }
}