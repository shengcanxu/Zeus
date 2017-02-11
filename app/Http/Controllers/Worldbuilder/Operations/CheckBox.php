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
    public $options = [];

    public function __construct($elements){
        parent::__construct($elements);

        $this->type = "checkbox";

        $this->columnType = "string";
        $this->length = 1000;
        if(isset($elements["options"])){
            $this->elements = $elements["options"];
        }
    }

    public function addDefaultValue(){
        $this->name = "Title";
        $this->elements[0] = "content1";
        $this->elements[1] = "content2";
        return $this;
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
        $checkboxString = str_replace('CHECKBOX_DESCRIPTION', $this->name, $checkboxString);

        $options = "";
        $optionTemplate = "    <input type='radio' name='" . $this->name . "' node='name'/> <label node='options'>CHECKBOX_CONTENT</label>\n";
        foreach ($this->elements as $element){
            $option = str_replace('CHECKBOX_CONTENT', $element, $optionTemplate);
            $options = $options . $option . "<br/>";
        }
        $checkboxString = str_replace('CHECKBOX_OPTIONS', $options, $checkboxString);

        return $checkboxString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/checkboxEditing.stub");

        //<input type="text" name="checkbox_options" node="name" />
        return $editingString;
    }

    public function fromJson($node)
    {
        parent::fromJson($node);

        $this->elements = $node->elements;
    }
}