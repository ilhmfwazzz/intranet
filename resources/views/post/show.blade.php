
@extends('layouts.app')
   
   @section('content')
   
@foreach($posts as $post=>$key)
	<div class="panel panel-default">
		<div class="panel-body">
			<p style="font-size:16px;"> {{ $post->name }}</p>
			<!-- <p style="font-size:11px; margin-top:-10px;">{{ date('M d, Y h:i A', strtotime($post->created_at)) }}</p>
			<h3 style="padding-top:30px; padding-bottom:30px;">{{ $post->post }}</h3>
		</div>
		<div class="panel-footer">
			<div class="row">
				<div class="col-md-2">
					<button class="btn btn-primary btn-sm"><i class="fa fa-thumbs-up"></i> <span>Like</span></button>
				</div>
				<div class="col-md-10" style="margin-left:-40px;">
					<button type="button" class="btn btn-primary btn-sm comment" value="{{ $post->postid }}"><i class="fa fa-comments"></i> Comment</button>
				</div>
			</div>
		</div>
	</div>
	<div id="commentField_{{ $post->postid }}" class="panel panel-default" style="padding:10px; margin-top:-20px; display:none;">
		<div id="comment_{{ $post->postid }}">
		</div>
		<form id="commentForm_{{ $post->postid }}">
			<input type="hidden" value="{{ $post->postid }}" name="postid">
			<div class="row"> 
				<div class="col-md-10">
					<input type="text" name="commenttext" id="commenttext" data-id="{{ $post->postid }}" class="form-control commenttext" placeholder="Write a Comment...">
				</div>
				<div class="col-md-2" style="margin-left:-25px;">
					<button type="button" class="btn btn-primary submitComment" value="{{ $post->postid }}"><i class="fa fa-comment"></i> Submit</button>
				</div>
			</div>
 
		</form>
	</div> -->
@endforeach
@endsection