@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Attendance</h2>
        </div>
    </div>
</div>


@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif



{!! Form::open(array('route' => 'attendances.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Category:</strong>
            {!! Form::select('category', $categories,[], array('class' => 'form-control select2')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Keterangan:</strong>
            {!! Form::text('note', null, array('placeholder' => 'Keterangan','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <div class="col-xs-6 col-sm-3 col-md-2 ml-0 mr-auto">
                <a class="btn btn-primary" href="{{ route('attendances.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-2 mr-0 ml-auto text-right">
                <button type="submit" id="submit" class="btn btn-success">Submit</button>
                <script type="text/javascript" defer="defer">
                    var enableDisable = function() {
                        var UTC_hours = new Date().getUTCHours() + 7;
                        if (UTC_hours >= 12 || UTC_hours < 6) {
                            document.getElementById('submit').disabled = true;
                        } else {
                            document.getElementById('submit').disabled = false;
                        }
                    };
                    setInterval(enableDisable, 1000 * 60);
                    enableDisable();
                    // 
                </script>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection