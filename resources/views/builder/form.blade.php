@extends("layouts.app")


<script src="js/jquery-3.1.1.js"></script>
<link href="/learnlaravel/public/css/bootstrap.css" rel="stylesheet">


@section('content')
    <div id="content" class="container">
        <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">Form</div>
                    <div class="panel-body">
                        <form id="{{$formName}}" action="{{$submitUrl}}" method="post">
                            <div>
                                @foreach($nodes as $node)
                                    {!! $node->htmlString() !!}
                                @endforeach
                            </div>
                            <br/>
                            {!! csrf_field() !!}
                            <input type="submit" class="btn btn-success" value="确定" />

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection