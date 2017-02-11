<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 22:01
 */

namespace App\Http\Controllers\Worldbuilder;


use Illuminate\Contracts\Filesystem\Filesystem;

class TextView extends Node
{
    public $content = "";

    public function __construct($elements){
        parent::__construct($elements);

        $this->type = "textview";
        $this->columnType = "text";
        $this->inDB = false;

        if(isset($elements["content"])){
            $this->name = $elements["content"];
            $this->content = $elements["content"];
        }
    }

    public function addDefaultValue(){
        $this->name = "TitleView Description";
        return $this;
    }

    public function migrationText(){
        return "";
    }

    public function htmlString(){
        $textViewString = $this->files->get(__DIR__ . "/../template/textview.stub");
        $textViewString = str_replace('TEXTVIEW_CONTENT', $this->name, $textViewString);
        return $textViewString;
    }

    public function editingString(){
        $editingString = $this->files->get(__DIR__ . "/../template/textviewEditing.stub");
        return $editingString;
    }

    public function fromJson($node)
    {
        parent::fromJson($node);

        $this->content = $node->content;
    }

}