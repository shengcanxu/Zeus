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
            (new CheckBox([]))->addDefaultValue(),
            (new TextView([]))->addDefaultValue()
        );

        return view("builder/build")
            ->with("formName", "FormName")
            ->with("nodes",$nodes);

    }

    public function store(Request $request){
        $operation = new BuilderOperation();
        $operation->handle($request);

        return redirect("/worldbuilder");
    }
}
