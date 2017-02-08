<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 22:01
 */

namespace App\Http\Controllers\Worldbuilder;


class CheckBox extends Node
{
    public $elements = [];

    public function __construct($elements){
        parent::__construct($elements);

        $this->type = "checkbox";

        $this->columnType = "integer";
        if(isset($elements["elements"])){
            $this->elements = $elements["elements"];
        }
    }

    public function migrationText(){
        return sprintf("\$table->%s('%s'%s);" . PHP_EOL . '            ' ,
            $this->columnType,
            $this->name,
            $this->length > 0 ? ", $this->length" : ''
        );
    }

    public function htmlString(){
        $checkboxString = $this->files->get(__DIR__ . "/../template/checkbox.stub");
        $checkboxString = str_replace('CHECKBOX_DESCRIPTION', "Title", $checkboxString);
        $checkboxString = str_replace('CHECKBOX_CONTENT1', "content1", $checkboxString);
        $checkboxString = str_replace('CHECKBOX_CONTENT2', "content2", $checkboxString);

        return $checkboxString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/checkboxEditing.stub");
        return $editingString;
    }

    public function fromJson($node)
    {
        parent::fromJson($node);

        $this->elements = $node->elements;
    }
}