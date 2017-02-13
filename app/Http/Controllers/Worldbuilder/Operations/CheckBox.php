<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 22:01
 */

namespace App\Http\Controllers\Worldbuilder;
use Illuminate\Http\Request;


class CheckBox extends Node
{
    public $options = [];

    public function __construct($elements){
        parent::__construct($elements);

        $this->type = "checkbox";

        $this->columnType = "string";
        $this->length = 700;
        if(isset($elements["options"])){
            $this->options = $elements["options"];
        }
    }

    public function addDefaultValue(){
        $this->name = "Title";
        $this->options[0] = "content1";
        $this->options[1] = "content2";
        return $this;
    }

    /**
     * @param \Request $request
     * @return return fail string or empty means success
     */
    public function valueCheck(Request $request){
        $failstring = parent::valueCheck($request);

        return $failstring;
    }

    public function migrationText(){
        return sprintf("\$table->%s('%s'%s)%s%s;" . PHP_EOL . '            ' ,
            $this->columnType,
            $this->name,
            $this->length > 0 ? ", $this->length" : '',
            $this->required ? '' : '->nullable()',
            $this->unique ? '->unique()' : ''
        );
    }

    public function htmlString(){
        $checkboxString = $this->files->get(__DIR__ . "/../template/checkbox.stub");
        return $checkboxString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/checkboxEditing.stub");
        return $editingString;
    }

    public function fromJson($node)
    {
        parent::fromJson($node);

        $this->options = $node->options;
    }
}