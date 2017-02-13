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

            $nodeClasses = array(
                (new TextBox([]))->addDefaultValue(),
                (new CheckBox([]))->addDefaultValue(),
                (new TextView([]))->addDefaultValue()
            );

            return view("builder/form")
                ->with('formName', $formName)
                ->with('submitUrl', url('/forms/'.$formName))
                ->with('nodes', $sortedNodes)
                ->with('nodeClasses', $nodeClasses);
        }else{
            return "Error: No Form with name: " . $formName;
        }
    }

    /**
     * @param Request $request
     * @param $formName
     * @return fail string. if fail string is empty, means success;
     */
    public function  valueCheck(Request $request, $formName){
        $nodes = $this->getFormNodes($formName);

        $failString = "";
        foreach ($nodes as $node){
            $value = $request->get($node->name);
            $fail = $node->valueCheck($value,$formName);
            $failString = $failString . $fail;
        }
        return $failString;
    }

    private function getFormNodes($formName){
        $formModel = new Form();
        $form = $formModel->where("form_name", "=", $formName)->first();
        if($form){
            $nodes = [];
            foreach ($form->nodes as $node){
                $jsonObject = json_decode($node['json']);
                $nodeObject = $this->fillNodeObject($jsonObject);
                array_push($nodes, $nodeObject);
            }
            return $nodes;
        }else{
            return [];
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
