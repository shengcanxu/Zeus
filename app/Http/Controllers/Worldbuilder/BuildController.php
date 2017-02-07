<?php

namespace App\Http\Controllers\Worldbuilder;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Worldbuilder\BuilderOperation;

class BuildController extends Controller{

    public function index(){
        $nodes = array(
            new TextBox([]),
            new CheckBox([])
        );

        return view("builder/build")
            ->with("formName", "testForm")
            ->with("nodes",$nodes);

    }

    public function store(Request $request){
        $operation = new BuilderOperation();
        $operation->handle($request);

        return redirect("/worldbuilder");
    }
}
