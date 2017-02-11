@extends("layouts.app")


<script src="js/jquery-3.1.1.js"></script>
<link href="/learnlaravel/public/css/bootstrap.css" rel="stylesheet">


@section('content')
    <div id="content" class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">{{$formName}}</div>
                <div class="panel-body">
                    <form id="{{$formName}}" action="{{$submitUrl}}" method="post">
                        <div id="formcontent">

                        </div>
                        <br/>
                        {!! csrf_field() !!}
                        <input type="submit" class="btn btn-success" value="确定" />

                    </form>
                </div>
            </div>
        </div>

        <div id="nodes" style="display: none;">
            @foreach($nodes as $node)
                {!! $node->htmlString()!!}
            @endforeach
        </div>
    </div>

    <script language="javascript" src="{{url('/js/builder.js')}}"></script>

    <script language="javascript">
        window.formObject={
            name : "{{$formName}}",
            elements : []
        };
        @foreach($nodes as $node)
        window.formObject.elements.push({!! $node->toJson() !!});
        @endforeach

        formFunc.buildForm();
    </script>

@endsection