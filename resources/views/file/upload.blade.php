@extends('layouts.app')
@section('content')
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

<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-12 justify-content-center mx-auto text-center">
            <div class="card">
                <h5 class="card-header">File Upload</h5>
                <div class="card-body">
                    <form action="{{ route('uploadfile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <strong>Category :</strong>
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id='category' name='category'>
                                @if (is_array($file_category) || is_object($file_category))
                                @foreach($file_category as $cat)
                                <option value='{{$cat->id_file_category}}'>{{$cat->category}}</option>
                                @endforeach
                                @endif    
                                </select>
                                <input type="file" name="file">                                                    
                            </div>
                            <button type="submit" class="btn btn-primary">UPLOAD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection