<?php

namespace App\Http\Controllers;

use App\Form_Name;
use Illuminate\Http\Request;

class Form_NameController extends Controller
{
    /**
     * @var Form_Name
     */
    private $formName;

    /**
     * @param Form_Name $formName
     */
    public function __construct(Form_Name $formName)
    {
        $this->formName = $formName;
    }

    /**
     * Return all Form_Names.
     *
     * @return mixed
     */
    public function index()
    {
        return $formNames = $this->formName->paginate();

        // return view('form_name.index', compact('formNames'));
    }

    /**
     * Display a given Form_Name.
     *
     * @param int $id Form_Name identifier
     * @return mixed
     */
    public function show($id)
    {
        return $formName = $this->formName->findOrFail($id);

        // return view('form_name.show', compact('formName'));
    }

    /**
     * Display the form to edit an existing Form_Name instance.
     *
     * @param int $id Form_Name identifier
     */
    public function edit($id)
    {
        $formName = $this->formName->findOrFail($id);

        // return view('form_name.edit', compact('formName'));
    }

    /**
     * Update an existing Form_Name instance.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Display the form to create a new Form_Name.
     */
    public function create()
    {
        // return view('form_name.create');
    }

    /**
     * Store a new Form_Name.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        // $created = $this->formName->create($request->all());

        // return redirect()->route('form_name.show')->with(['id' => $created->id]);
    }

}

?>
