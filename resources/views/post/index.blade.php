@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">POST SESUKA HATI</div>
                <div class="card-body">
                    <form method="post" action="{{ route('post') }}">
                    @csrf
                        <div class="form-group" margin-to= "25px">
                            <input type ="text" id="post" name ="post" rows="2" cols="10" class="form-control" placeholder="What's on your mind?" required></textarea>
                        </div>
                        
                            <button type="submit" class="btn btn-primary">POST</button>
                    </form>
                </div>
            </div>
            @foreach ($posts as $post)
            <div class="card">
                <div class="card-body">
                    <strong>{{ $post->user->name }}</strong>
                    <p>
                        {{ $post->post }}
                    </p>
                    <hr />
                    <h6>Add comment</h4>
                    
                    <hr />
                    <form method="post" action="{{ route('comment') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="comment_body" class="form-control" />
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning" value="Add Comment" />
                        </div>
                        @foreach($post->comments as $comment)
                        <div class="display-comment">
                            <strong>{{ $comment->user->name }}</strong>
                            <p>{{ $comment->comment }}</p>
                        </div>
                    @endforeach
                    </form>
                </div>
            </div>
                
            @endforeach
            
        </div>
    </div>
</div>
@endsection