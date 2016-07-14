<?php

namespace App\Http\Controllers;

use DB;

class LinkHelper extends Controller
{

    public static function handleRequest($keyword){
        $result = DB::select('select * from links WHERE tag like ? limit 1',[$keyword]);

        foreach ($result as $row){
            return "Here is the <a href='$row->link'> link </a> to". $keyword ." the you requested. \n";
        }
    }

}
