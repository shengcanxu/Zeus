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
        $this->length = 1000;

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

    public function migrationText(){
        return sprintf("\$table->%s('%s'%s);" . PHP_EOL . '            ' ,
            $this->columnType,
            $this->name,
            $this->length > 0 ? ", $this->length" : ''
        );
    }

    public function htmlString(){
        $textBoxString = $this->files->get(__DIR__ . "/../template/textbox.stub");
        $textBoxString = str_replace('TEXTBOX_DESCRIPTION', $this->name, $textBoxString);
        $textBoxString = str_replace('TEXTBOX_NAME', $this->name, $textBoxString);
        $textBoxString = str_replace('TEXTBOX_CONTENT', $this->content, $textBoxString);
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