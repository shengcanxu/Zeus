<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 22:01
 */

namespace App\Http\Controllers\Worldbuilder;


use Illuminate\Contracts\Filesystem\Filesystem;

class TextBox extends Node
{
    public $content = "";

    public function __construct($elements){
        parent::__construct($elements);

        $this->type = "textbox";
        $this->columnType = "string";
        $this->length = 100;

        if(isset($elements["length"])){
            $this->length = (int) $elements["length"];
        }

        if(isset($elements["content"])){
            $this->content = $elements["content"];
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
        $textBoxString = $this->files->get(__DIR__ . "/../template/textbox.stub");
        $textBoxString = str_replace('TEXTBOX_DESCRIPTION', "Title", $textBoxString);
        $textBoxString = str_replace('TEXTBOX_CONTENT', "", $textBoxString);
        return $textBoxString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/textboxEditing.stub");
        return $editingString;
    }

    public function toJson(){
        return "{'id':'" . $this->id . "','name':'" . $this->name . "','type':'" . $this->type . "'}";
    }

}