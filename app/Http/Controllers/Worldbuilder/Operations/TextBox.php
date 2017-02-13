<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 22:01
 */

namespace App\Http\Controllers\Worldbuilder;


use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;

class TextBox extends Node
{
    public $content = "";

    public function __construct($elements){
        parent::__construct($elements);

        $this->type = "textbox";
        $this->columnType = "string";
        $this->length = 700;

        if(isset($elements["length"])){
            $this->length = (int) $elements["length"];
        }

        if(isset($elements["content"])){
            $this->content = $elements["content"];
        }
    }

    public function addDefaultValue(){
        $this->name = "Title";
        return $this;
    }

    /**
     * @param \Request $request
     * @return return fail string or empty means success
     */
    public function valueCheck(Request $request,$formName){
        $failstring = parent::valueCheck($request,$formName);

        return $failstring;
    }

    public function migrationText(){
        return sprintf("\$table->%s('%s'%s)%s%s;" . PHP_EOL . '            ' ,
            $this->columnType,
            $this->name,
            $this->length > 0 ? ", $this->length" : '',
            $this->required===true ? '' : '->nullable()',
            $this->unique===true ? '->unique()' : ''
        );
    }

    public function htmlString(){
        $textBoxString = $this->files->get(__DIR__ . "/../template/textbox.stub");
        $textBoxString = str_replace("{'OBJNAME':'OBJVALUE'}", json_encode($this),$textBoxString);
        return $textBoxString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/textboxEditing.stub");
        return $editingString;
    }

    public function fromJson($node)
    {
        parent::fromJson($node);

        $this->content = $node->content;
    }

}