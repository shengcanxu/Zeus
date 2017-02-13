<?php

namespace App\Http\Controllers\Worldbuilder;

use App\FormNode;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Worldbuilder\BuilderOperation;

class BuildController extends Controller{

    public function index(){
        $nodes = array(
            (new TextBox([]))->addDefaultValue(),
            (new RadioBox([]))->addDefaultValue(),
            (new CheckBox([]))->addDefaultValue(),
            (new TextView([]))->addDefaultValue()
        );

        return view("builder/build")
            ->with("formName", "FormName")
            ->with("nodes",$nodes);

    }

    public function store(Request $request){
        for($i = 0; $i<count($request->elements); $i++){
            for($j = $i+1; $j<count($request->elements); $j++){
                if($request->elements[$i]["name"] == $request->elements[$j]["name"]){
                    return redirect("/error");
                }
            }
        }

        $operation = new BuilderOperation();
        $operation->handle($request);

        return redirect("/worldbuilder");
    }
}
