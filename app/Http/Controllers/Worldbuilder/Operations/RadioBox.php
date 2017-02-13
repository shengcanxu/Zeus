<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 22:01
 */

namespace App\Http\Controllers\Worldbuilder;
use Illuminate\Http\Request;


class RadioBox extends Node
{
    public $options = [];

    public $defaultValue = '';

    public $allowOthers = false;

    public function __construct($element){
        parent::__construct($element);

        $this->type = "radiobox";
        $this->columnType = "string";
        $this->length = 700;

        if(isset($element["options"])){
            $this->options = $element["options"];
        }

        if(isset($element["defaultValue"])){
            $this->defaultValue = $element["defaultValue"];
        }

        if(isset($element["allowOthers"])){
            $this->allowOthers = $element["allowOthers"] == 'true' ? true : false;
        }
    }

    public function addDefaultValue(){
        $this->name = "Title";
        $this->options[0] = "radiocontent1";
        $this->options[1] = "radiocontent2";
        return $this;
    }

    /**
     * @param \Request $request
     * @return return fail string or empty means success
     */
    public function valueCheck($value,$formName){
        $failstring = parent::valueCheck($value,$formName);

        return $failstring;
    }

    public function migrationText(){
        return sprintf("\$table->%s('%s'%s)%s;" . PHP_EOL . '            ' ,
            $this->columnType,
            $this->name,
            $this->length > 0 ? ", $this->length" : '',
            $this->required ? '' : '->nullable()'
        );
    }

    public function htmlString(){
        $radioboxString = $this->files->get(__DIR__ . "/../template/radiobox.stub");
        return $radioboxString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/radioboxEditing.stub");
        return $editingString;
    }

    public function fromJson($node)
    {
        parent::fromJson($node);

        $this->options = $node->options;
        $this->defaultValue = $node->defaultValue;
        $this->allowOthers = $node->allowOthers;
    }
}