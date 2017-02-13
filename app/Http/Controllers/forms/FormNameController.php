<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\FormController;
use App\Models\FormName;
use Illuminate\Http\Request;

class FormNameController extends FormController
{
    /**
     * @var FormName
     */
    private $formName = "FormName";

    public function index(Request $request)
    {
        return $this->show($request, $this->formName);
    }


    /**
     * Update an existing FormName instance.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Display the form to create a new FormName.
     */
    public function create()
    {
        // return view('formname.create');
    }

    public function store(Request $request)
    {
        $formName = new FormName();
        $formName->Title2 = $request->get('Title2');
        $formName->Title3 = $request->get('Title3');
        

        $failString = $this->valueCheck($request, $this->formName);
        if(strlen($failString) >0){
            return "value check fails:<br/>" . $failString;
        }

        if($formName->save()){
            return "save " . $this->formName . " successfully";
        }else{
            return "fail to save " . $this->formName;
        }
    }
}

?>
