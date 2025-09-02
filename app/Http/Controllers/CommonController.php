<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    //
    public function visitor_types(){
        $data[0] =[
            'id' => '',
            'text' => 'Select Visitor Type'
        ];

        foreach(visitor_types() as $record){
            array_push($data,[
                'id' => $record->id,
                'text' => $record->name
            ]);
        }

        return response()->json($data);
    }
}
