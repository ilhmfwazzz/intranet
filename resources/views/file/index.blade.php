@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-4 col-sm-12 justify-content-center mx-auto text-center">
        <h2 class="mb-3">UPLOAD FILE DISINI YA</h2>
        <a href="{{ route('formfile') }}">
            <input type="button" value="UPLOAD" class="btn btn-primary" />
        </a>
    </div>
    </div>
    @endsection