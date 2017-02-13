<?php
/**
 * Created by PhpStorm.
 * User: cano
 * Date: 2017/2/3
 * Time: 21:57
 */

namespace App\Http\Controllers\Worldbuilder;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Node
{
    protected $files;

    public $id = 0;

    public $type = "node";

    public $name = "";

    public $description = "";

    public $columnType = "string";

    public $length = 0;

    public $required = false;

    public $unique = false;

    /**
     * @var bool 表示是不是需要创建数据库字段，是否需要用户输入
     */
    public $inDB = true;

    public function __construct($element){
        $this->files = new Filesystem();

        if(isset($element["id"])){
            $this->id = $element["id"];
        }

        if(isset($element["name"])){
            $this->name = $element["name"];
        }

        if(isset($element["description"])){
            $this->description = $element["description"];
        }elseif (isset($element["name"])){
            $this->description = $element["name"];
        }

        if(isset($element["required"])){
            $this->required = $element["required"] == "true" ? true : false;
        }

        if(isset($element["unique"])){
            $this->unique = $element["unique"] == "true" ? true : false;
        }

        if(isset($element["description"])){
            $this->description = $element["description"];
        }
    }

    /**
     * @param \Request $request
     * @return return fail string or empty means success
     */
    protected function valueCheck($value,$formName){
        $failstring = "";
        if($this->required){
            if($value == null || strlen(trim($value)) == 0){
                $failstring = "Error: " . $this->name . " 是必填<br/>";
            }
        }
        if($this->unique){
            $tableName = strtolower(Str::plural(Str::snake($formName)));
            $columnValues = DB::select("select " . $this->name . " from " . $tableName );
            foreach($columnValues as $column){
                $columnArray = (array)$column;
                if($value == $columnArray[$this->name]){
                    $failstring = "Error: " . $this->name . " 的值 " . $value . " 已经存在!<br/>";
                }
            }
        }
        return $failstring;
    }

    public function toJson(){

        $json = json_encode($this);
        return $json;
    }

    public function fromJson($node){
        $this->id = $node->id;
        $this->type = $node->type;
        $this->name = $node->name;
        $this->description = $node->description;
        $this->columnType = $node->columnType;
        $this->length = $node->length;
        $this->required = $node->required;
        $this->unique = $node->unique;
        $this->description = $node->description;
    }
}