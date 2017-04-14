<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UserChangedActiveCell;

class ActiveCellController extends Controller
{

    public function method(Request $request){
        $rowIndex=$request->rowIndex;
        $columnIndex=$request->columnIndex;

        event(new  UserChangedActiveCell($rowIndex,$columnIndex));
    }
}
