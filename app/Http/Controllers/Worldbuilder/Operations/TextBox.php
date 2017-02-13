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

    public $shouldAllNumber = false;

    public $maxLength = 0;

    public $minNumber = 0;

    public $maxNumber = 0;

    public $defaultValue = '';

    public function __construct($element){
        parent::__construct($element);

        $this->type = "textbox";
        $this->columnType = "string";
        $this->length = 700;

        if(isset($element["length"])){
            $this->length = (int) $element["length"];
        }

        if(isset($element["content"])){
            $this->content = $element["content"];
        }

        if(isset($element["shouldAllNumber"])){
            $this->shouldAllNumber = $element["shouldAllNumber"] == 'true' ? true : false;
            if($this->shouldAllNumber){
                $this->columnType = "double";
                $this->length = "30,10";
            }
        }

        if(isset($element["maxLength"])){
            $this->maxLength = (int) $element["maxLength"];
        }

        if(isset($element["minNumber"])){
            $this->minNumber = (int) $element["minNumber"];
        }

        if(isset($element["maxNumber"])){
            $this->maxNumber = (int) $element["maxNumber"];
        }

        if(isset($element["defaultValue"])){
            $this->defaultValue = $element["defaultValue"];
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
    public function valueCheck($value,$formName){
        $failstring = parent::valueCheck($value,$formName);

        if($this->shouldAllNumber){
            if(!is_numeric($value)){
                $failstring = $failstring . $this->name . " 的值必须是数字!<br/>";
            }
        }
        if(!$this->shouldAllNumber && $this->maxLength > 0){
           if(strlen($value) > $this->maxLength){
               $failstring = $failstring . $this->name . " 的值过长,不能超过" . $this->maxLength;
           }
        }
        if($this->shouldAllNumber && ($this->maxNumber!=0 || $this->minNumber!=0)){
            $intValue = (int)$value;
            if(($intValue > $this->maxNumber) || $intValue < $this->minNumber){
                $failstring = $failstring . $this->name . " 的值必须在范围[" . $this->minNumber . " , " . $this->maxNumber . "]";
            }
        }

        return $failstring;
    }

    public function migrationText(){
        return sprintf("\$table->%s('%s'%s)%s%s;" . PHP_EOL . '            ' ,
            $this->columnType,
            $this->name,
            $this->length > 0  ? ", $this->length" : '',
            $this->required===true ? '' : '->nullable()',
            $this->unique===true ? '->unique()' : ''
        );
    }

    public function htmlString(){
        $textBoxString = $this->files->get(__DIR__ . "/../template/textbox.stub");
        //$textBoxString = str_replace("{'OBJNAME':'OBJVALUE'}", json_encode($this),$textBoxString);
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
        $this->shouldAllNumber = $node->shouldAllNumber;
        $this->maxLength = $node->maxLength;
        $this->minNumber = $node->minNumber;
        $this->maxNumber = $node->maxNumber;
        $this->defaultValue = $node->defaultValue;
    }

}