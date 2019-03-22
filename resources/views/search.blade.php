@extends('layouts.master')

@section('header')
<style type="text/css" media="screen">
  .tab-outline .nav.nav-tabs .nav-item .nav-link{
    padding: 10px 20px !important;
  }
  #myTabContent .card, #myTabContent p{
    margin-bottom: 10px;
  }
  .tab-outline .tab-content{
    padding: 16px 10px;
  }
  .card:hover{
    background-color: #e6e6e6;
  }
  .card a:hover h3{
    color: orange;
  }
  #search-group{
    display: flex;
    width: 100%;
    margin-bottom: 20px;
  }
  #search-group form{
    margin: auto;
  }
  #search-group .row{
    float: left;
    margin-right: 22px;
  }
  #search-group input, #search-group select{
    width: 200px;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="breadcrumb-link">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tìm kiếm</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-body posts">
        <div id="post-title" style="margin-bottom: 20px;">
          <h2 style="margin-bottom: 0;">Tìm kiếm: {{$search_name}} {{($category_name != '')? ' - chuyên mục: '.$category_name: '' }}</h2>
          <p>Có {{$number}} kết quả được tìm thấy</p>
        </div>
        {{-- Danh sách bài viết --}}
        <div id="post-group">
          @if(!empty($posts))
          @foreach($posts as $key => $post)
          <div class="card">
            <div class="card-body">
              <a href="{{ route('post.detail', $post->slug) }}" title="">
                <h3 style="margin-bottom: 0px;">TB số {{$post['id']}}: {{$post['post']}}</h3>
              </a>
              <p style="font-style: italic;"><span>{{date('d/m/Y', strtotime($post['created_at']))}}</span> - <span>{{$post['user_id']}}</span></p>
              <p> {!!$post['content']!!}</p>
              <a href="{{route('post.detail', $post['slug'])}}">
                <button type="button" class="btn btn-sm btn-info">Xem thêm</button>
              </a>
            </div>
          </div>
          @endforeach
          {{ $posts->links() }}
          @else
          Chưa có bài viết nào
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')

@endsection