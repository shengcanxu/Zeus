@extends("layouts.app")


<script src="/learnlaravel/public/js/jquery-3.1.1.js"></script>
<link href="/learnlaravel/public/css/bootstrap.css" rel="stylesheet">


@section('content')
    <div id="content" class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Controls</div>
                    <div class="panel-body">
                        <a href="#" id="addTextView" class="btn btn-default">文本</a>
                        <a href="#" id="addTextBox" class="btn btn-default">文本框</a>
                        <a href="#" id="addRadioBox" class="btn btn-default">单选框</a>
                        <a href="#" id="addCheckBox" class="btn btn-default">多选框</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" id="formname">{{$formName}}</div>
                    <div class="panel-body">
                        <div id="formcontent">

                        </div>
                        <br/>
                        <input type="button" class="btn btn-success" value="确定" id="submitForm" />
                    </div>
                </div>
            </div>

            <div id="editing" class="col-md-4" style="position: fixed;right: 0%;top: 0%;z-index: 10000;">
                <div class="panel panel-default">
                    <div class="panel-heading">Editing</div>
                    <div class="panel-content" id="editingContent">
                        <div class="formname" style="display:none">
                            <ul>
                                <li>
                                    <p>名称</p>
                                    <input type="text" name="form_name" id="formNameEditing" node="name"/>
                                </li>
                            </ul>
                            <script language="javascript">
                                var formnameediting = {
                                    initialize : function () {
                                        if(editingObject["name"]){
                                            $("#formNameEditing").val(editingObject["name"]);
                                        }
                                        $("#confirmEditing").attr("node","formName");
                                    },
                                    confirm : function () {
                                        editingObject["name"] = $("#formNameEditing").val();
                                        formFunc.refresh();
                                    }
                                }
                            </script>
                        </div>
                        @foreach($nodes as $node)
                            {!! $node->editingString() !!}
                        @endforeach
                    </div>
                    <div style="text-align:center;">
                        <a href="#" class="btn btn-default" id="confirmEditing" node="">确定</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="nodes" style="display: none;">
            @foreach($nodes as $node)
                {!! $node->htmlString()!!}
            @endforeach
        </div>

        <script language="javascript" src="{{url('/js/builder.js')}}"></script>


    </div>
@endsection