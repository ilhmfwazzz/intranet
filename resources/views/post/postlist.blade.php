@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">POST SESUKA HATI</div>
                <div class="card-body">
                    <form method="post" action="{{ route('postIndex') }}">
                    @csrf
                        <div class="form-group">
                            <input type ="text" id="post" name ="post" rows="2" cols="10" class="form-control" placeholder="What's on your mind?" required></textarea>
                        </div>
                        
                            <button type="submit" class="btn btn-primary">POST</button>
                    </form>
                </div>
            </div>
        
        </div>
    </div>
</div>
@endsection