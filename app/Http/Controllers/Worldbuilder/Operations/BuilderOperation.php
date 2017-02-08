<?php

namespace App\Http\Controllers\Worldbuilder;

use App\Form;
use App\FormNode;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Artisan;

class BuilderOperation{

    /**
     * The filesystem instance.
     */
    private $files;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var Node/TextBox/CheckBox
     */
    private $nodes = array();

    public function __construct()
    {
        $this->files = new Filesystem();
        $this->composer = new Composer($this->files, base_path());
    }


    public function handle(Request $request)
    {
        $name = trim($request->name);
        $elements = $request->elements;
        $this->buildNodes($elements);

        $this->createModel($name, $elements);
        $this->createMigration($name);
        $this->createController($name);
        $this->appendRoutes($name);

        Artisan::call("migrate");

        $this->addMetaData($request);
    }

    private function addMetaData(Request $request){
        $name = trim($request->name);
        $recordNum = Form::where("form_name", "=" , $name)->count();
        if($recordNum >0){
            return;
        }

        $form = new Form();
        $form->form_name = $name;
        $form->user_id = $request->user()->id;
        $form->save();

        foreach ($this->nodes as $node){
            $formNode = new FormNode();
            $formNode->form_id = $form->id;
            $formNode->node_name = $node->name;
            $formNode->json = $node->toJson();
            $formNode->save();
        }

    }

    private function buildNodes($elements){
        foreach ($elements as $element){
            switch ($element["type"]){
                case "textbox":
                    $textbox = new TextBox($element);
                    array_push($this->nodes, $textbox);
                    break;
                case "checkbox":
                    $checkbox = new CheckBox($element);
                    array_push($this->nodes, $checkbox);
                    break;
            }
        }
    }

    private function createController($modelName)
    {
        $filename = ucfirst($modelName) . 'Controller.php';

        if ($this->files->exists(app_path('Http/Controllers/forms/' .$modelName . '/' . $filename))) {
            $this->files->delete(app_path('Http/Controllers/forms/' .$modelName . '/' . $filename));
        }

        $stub = $this->files->get(__DIR__ . '/../template/controller.stub');

        $stub = str_replace('MyModelClass', ucfirst($modelName), $stub);
        $stub = str_replace('myModelInstance', Str::camel($modelName), $stub);
        $stub = str_replace('template', strtolower($modelName), $stub);

        if(!$this->files->exists(app_path('Http/Controllers/forms/'.$modelName))){
            $this->files->makeDirectory(app_path('Http/Controllers/forms/' . $modelName));
        }
        $this->files->put(app_path('Http/Controllers/forms/' .$modelName . '/' . $filename), $stub);

        info('Created controller ' . $filename);

        return true;
    }

    private function appendRoutes($modelName)
    {
        $modelTitle = ucfirst($modelName);
        $modelName = strtolower($modelName);

        //check if exist already
        $routerString = $this->files->get(base_path('routes/web.php'));
        if($routerString.containsString("'prefix' => 'form_name'")){
            return;
        }

        $newRoutes = $this->files->get(__DIR__ . '/../template/routes.stub');
        $newRoutes = str_replace('|MODEL_TITLE|', $modelTitle, $newRoutes);
        $newRoutes = str_replace('|MODEL_NAME|', $modelName, $newRoutes);
        $newRoutes = str_replace('|CONTROLLER_NAME|', $modelTitle . 'Controller', $newRoutes);

        $this->files->append(
            base_path('routes/web.php'),
            $newRoutes
        );

        info('Added routes for ' . $modelTitle);
    }

    /**
     * Create and store a new Model to the filesystem.
     *
     * @param string $name
     * @return bool
     */
    private function createModel($name,$elements)
    {
        $modelName = ucfirst($name);

        $filename = $modelName . '.php';

        if ($this->files->exists(app_path('/' . 'models/' . $filename))) {
            $this->files->delete(app_path('/'. 'models/' . $filename));
        }

        $model = $this->buildModel($name, $elements);

        $this->files->put(app_path('/' . 'models/' . $filename), $model);

        info($modelName . ' Model created');

        return true;
    }

    private function buildModel($name, $elements)
    {
        $stub = $this->files->get(__DIR__ . '/../template/model.stub');
        $stub = str_replace('NAME_PLACEHOLDER', $name, $stub);

        return $stub;
    }

    private function createMigration($name)
    {
        $filename = '2017_01_30_011059_create_' . Str::plural(Str::snake($name)) . '_table.php';

        if ($this->files->exists(database_path('/migrations/' . $filename))) {
            $this->files->delete(database_path('/migrations/' . $filename));
        }

        $migration = $this->buildMigration($name,$filename);

        $this->files->put(
            database_path('/migrations/' . $filename),
            $migration
        );

        if (env('APP_ENV') != 'testing') {
            $this->composer->dumpAutoloads();
        }

        info('Created migration ' . $filename);

        return true;
    }

    private function buildMigration($name, $filename)
    {
        $stub = $this->files->get(__DIR__ . '/../template/migration.stub');

        $filename = explode('.',$filename)[0];
        $className = Str::studly(implode('_', array_slice(explode('_', $filename), 4)));
        $stub = str_replace('MIGRATION_CLASS_PLACEHOLDER', $className, $stub);
        $table = strtolower(Str::plural($name));
        $stub = str_replace('TABLE_NAME_PLACEHOLDER', $table, $stub);

        $stub = str_replace('MIGRATION_COLUMNS_PLACEHOLDER', $this->buildTableColumns(), $stub);

        return $stub;
    }

    private function buildTableColumns(){
        $columnsText = array_reduce($this->nodes, function($text, $node){
           return $text . $node->migrationText();
        });

        return $columnsText;
    }
}
?>