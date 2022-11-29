@extends('layouts.app')
@section('content')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        <strong>{{ session('success') }}</strong>
    </div>
    @endif
    <div class="row">
        @if(is_array($files) || is_object($files))
        @foreach($files as $file)
        <div class="col-md-4">
            <div class="card">

                <div class="card-body">
                    <strong class="card-title">{{ $file->name }}</strong>
                    <p class="card-text">{{ $file->created_at}}</p>
                    <form action="{{ route('deletefile', $file->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <a href="{{ route('downloadfile',$file->id) }}" class="btn btn-primary">Download</a>
                    </form>


                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

@endsection