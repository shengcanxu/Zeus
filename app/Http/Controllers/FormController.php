<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormNode;
use App\Http\Controllers\Worldbuilder\CheckBox;
use App\Http\Controllers\Worldbuilder\TextBox;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Worldbuilder\TextView;
use Illuminate\Http\Request;

class FormController extends Controller{

    public function show(Request $request, $formName){
        $formClass = new Form();
        $form = $formClass->where("form_name","=",$formName)->first();

        if($form){
            $nodes = [];
            foreach ($form->nodes as $node){
                $jsonObject = json_decode($node['json']);
                $nodeObject = $this->fillNodeObject($jsonObject);
                array_push($nodes, $nodeObject);
            }

            $sortedNodes = collect($nodes)->sortBy("id")->all();

            return view("builder/form")
                ->with('formName', $formName)
                ->with('submitUrl', url('/forms/'.$formName))
                ->with('nodes', $sortedNodes);
        }else{
            return "Error: No Form with name: " . $formName;
        }
    }

    private function fillNodeObject($node){
        switch ($node->type){
            case "textbox":
                $textbox = new TextBox([]);
                $textbox->fromJson($node);
                return $textbox;
            case "checkbox":
                $checkbox = new CheckBox([]);
                $checkbox->fromJson($node);
                return $checkbox;
            case "textview":
                $textview = new TextView([]);
                $textview->fromJson($node);
                return $textview;
        }
    }
}
