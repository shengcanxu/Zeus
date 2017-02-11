<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 21:57
 */

namespace App\Http\Controllers\Worldbuilder;


use Illuminate\Filesystem\Filesystem;

class Node
{
    protected $files;

    public $id = 0;

    public $type = "node";

    public $unique = false;

    public $name = "";

    public $description = "";

    public $columnType = "string";

    public $length = 0;

    /**
     * @var bool 表示是不是需要创建数据库字段，是否需要用户输入
     */
    public $inDB = true;

    public function __construct($element){
        $this->files = new Filesystem();

        if(isset($element["id"])){
            $this->id = $element["id"];
        }
        if(isset($element["unique"])){
            $this->unique = true;
        }

        if(isset($element["name"])){
            $this->name = $element["name"];
        }

        if(isset($element["description"])){
            $this->description = $element["description"];
        }elseif (isset($element["name"])){
            $this->description = $element["name"];
        }
    }

    public function toJson(){

        $json = json_encode($this);
        return $json;
    }

    public function fromJson($node){
        $this->id = $node->id;
        $this->type = $node->type;
        $this->unique = $node->unique;
        $this->name = $node->name;
        $this->description = $node->description;
        $this->columnType = $node->columnType;
        $this->length = $node->length;
    }
}