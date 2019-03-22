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
  .system-item{
    margin: 10px;
    width: 146px;
    height: auto;
    float: left;
    text-align: center;
  }
  .system-item img{
    width: 120px;
    height: 100px;
    margin: auto;
  }
  .system-item p{
    margin: 5px auto;
  }
  #group-software{
    height: 1000px;
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="tab-outline">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tab-outline-post" data-toggle="tab" href="#outline-post">Thông báo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab-outline-contact" data-toggle="tab" href="#outline-contact">Danh bạ nội bộ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab-outline-system" data-toggle="tab" href="#outline-system">Chương trình quản lý</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="outline-post">

          {{-- form search --}}
          <div id="search-group">
            <form action="{{ route('home.search') }}" method="GET" accept-charset="utf-8">
              <div class="row">
                <input type="text" name="search_name" class="form-control-sm" id="search_name" placeholder="Tìm kiếm...">
              </div>
              <div  class="row">
                <select name="category_id"  class="form-control-sm" id="category_id">
                  <option value="all">Tất cả</option>
                  @foreach($categories as $key => $category)
                  <option value="{{$category['id']}}">{{$category['category']}}</option>
                  @endforeach
                </select>
              </div>
              <div class="row">
                <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
              </div>
            </form>
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

        <div class="tab-pane fade" id="outline-contact">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="user-table" style="width: 100%;">
                  <thead>
                    <tr>
                     <th class="stl-column color-column">STT</th>
                     <th class="stl-column color-column">Họ tên</th>
                     <th class="stl-column color-column">Giới tính</th>
                     <th class="stl-column color-column">Email</th>
                     <th class="stl-column color-column">Điện thoại</th>
                     <th class="stl-column color-column">Địa chỉ</th>
                   </tr>
                 </thead>
               </table>
             </div>
           </div> 
         </div>
       </div>

       <div class="tab-pane fade" id="outline-system">

        <div id="group-software">
          @foreach ($links as $key => $link)
          <div class="system-item">
            <a href="{{ $link['links'] }}" title="">
              <img src="{{ asset('images/'.$link['img']) }}" alt="loading...">
              <p>{{ $link['name'] }}</p>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('footer')

<script>
  var userTable = $('#user-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('contactUser.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'50px'},
    {data: 'name', name: 'name', 'width':'200px'},
    {data: 'gender', name: 'gender', 'class':'dt-center', 'width':'57px'},
    {data: 'email', name: 'email', 'width':'160px'},
    {data: 'phone', name: 'phone', 'class':'dt-right', 'width':'100px'},
    {data: 'address', name: 'address'},
    ]
  });

  $('#tab-outline-post').click(function(){
    $('#outline-post').show();
    $('#outline-contact').hide();
    $('#outline-system').hide();
  });

  $('#tab-outline-contact').click(function(){ 
    $('#outline-post').hide();
    $('#outline-contact').show(); 
    $('#outline-system').hide(); 
    userTable.ajax.reload(null, false);
  });

  $('#tab-outline-system').click(function(){
    $('#outline-post').hide();
    $('#outline-contact').hide();
    $('#outline-system').show(); 
  });
</script>
@endsection