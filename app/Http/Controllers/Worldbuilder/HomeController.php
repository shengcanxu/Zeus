<?php

namespace App\Http\Controllers\Worldbuilder;

use Illuminate\Routing\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class HomeController extends Controller{


    public function store(Request $request){
        $this->validate($request, [

        ]);

        return redirect("/builder");
    }
}
