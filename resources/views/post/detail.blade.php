@extends('layouts.master')

@section('header')
<style type="text/css" media="screen">
	.post-title{
		font-size: 23px;
    	font-weight: bold;
	}
	.page-breadcrumb .breadcrumb{
		border-top: none;
		font-size: 13px;
	}
	#file-download{
		position: relative;
		width: 80px;
	}
	.post-extend p{
		font-weight: bold;
		margin-bottom: 0px;
		margin-top: 30px;
	}
	#file-download img{
		width: 50px;
		margin: 10px 15px;
	}
	#file-download i{
		position: absolute;
		top: 24px;
	    left: 30px;
	    font-size: 25px;
	    color: #3a3030;
	    display: none;
	}
	#file-download:hover{
		cursor: pointer;
		background-color: rgba(1,1,1,0.1);
	}
	#file-download:hover #icon{
		display: block;
	}
</style>
@endsection

@section('content')
<div class="row" style="margin-bottom: 100px;">
	<div class="col-md-12 col-lg-12 col-xs-12">

		<div class="page-header">
			<div class="page-breadcrumb">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb-link">Trang chủ</a></li>
						<li class="breadcrumb-item active" aria-current="page">Bài viết</li>
					</ol>
				</nav>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-body posts">

				<div class="post-item">
					<div class="post-title">
						{{$post->post}}
					</div>
					<div class="post-date margin_bottom"><span class="fa fa-calendar"></span> {{date('d/m/Y', strtotime($post->created_at))}} - {{$post->user_id}}
					</div>
					<div class="post-text dt-justify">
						{!! $post->content !!}
					</div>
					<div class="post-row">
						@if($post->files != '')
						<div class="post-extend">
							<p>File đính kèm:</p>
							<a href="{{ route('file.download', $post->files) }}" title="">
							<div id="file-download">
								<img src="{{ asset('images/multiple_files-512.png') }}" alt="">
								<i class="fas fa-download" id="icon"></i></img>
							</div>
							</a>
						</div>
						@endif
					</div>
				</div>                                            

			</div>
		</div>

	</div>

</div>
@endsection

@section('footer')

@endsection