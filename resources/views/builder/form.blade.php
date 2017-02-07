@extends("layouts.app")


<script src="js/jquery-3.1.1.js"></script>
<link href="/learnlaravel/public/css/bootstrap.css" rel="stylesheet">


@section('content')
    <div id="content" class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Controls</div>
                    <div class="panel-body">
                        <a href="javascript:addTextBox()" class="btn btn-default">文本框</a>
                        <a href="javascript:addCheckBox()" class="btn btn-default">单选框</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Form</div>
                    <div class="panel-body">
                        <form id="{{$formName}}" action="{{url("/builder/")}}" method="post">
                            <div>

                            </div>
                            <br/>
                            {!! csrf_field() !!}
                            <input type="submit" class="btn btn-success" value="确定" />

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="nodes" style="display: none;">
            <div class="textbox">
                {!!$textBoxString!!}
            </div>
            <div class="checkbox">
                {!! $checkBoxString !!}
            </div>
        </div>

        <script language="javascript">
            function addTextBox(){
                $("#nodes .textbox").clone().appendTo($("#{{$formName}} > div"));
            }

            function addCheckBox(){
                $("#nodes .checkbox").clone().appendTo($("#{{$formName}} > div"));
            }
        </script>
    </div>
@endsection