@extends('layouts.master')

@section('header')
<style type="text/css" media="screen">
.modal-body div button{
  color: #222f3e !important;
}
.group_file{
  position: relative;
}
.clear_file{
  position: absolute;
  bottom: 8px;
  right: 10px;
  font-size: 22px;
  display: none;
}
.clear_file:hover{
  cursor: pointer;
}

#name_file{
  width: 25%;
  position: absolute;
  bottom: 10px;
  left: 84px;
  background: white;
}

</style>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h3 class="mb-2">Quản lý bài viết </h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Quản trị</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5" style="margin-bottom: 15px;">
        {{-- @if (Entrust::can(["slides-add"])) --}}
        <a data-toggle="modal" href="#modalCreateEdit" id="createFrom"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Thêm mới</button>
        </a>
        {{-- @endif --}}
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="post-table">
            <thead>
              <tr>
               <th class="stl-column color-column">STT</th>
               <th class="stl-column color-column">Tên bài viết</th>
               <th class="stl-column color-column">Người đăng</th>
               <th class="stl-column color-column">Chuyên mục</th>
               <th class="stl-column color-column" style="text-align: center;">Nội dung</th>
               <th class="stl-column color-column">Ngày tạo</th>
               <th class="stl-column color-column">Hành động</th>
             </tr>
           </thead>
         </table>
       </div>
     </div> 
   </div>
 </div>
</div>

<div class="modal" id="modalCreateEdit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header center">
        <h4 class="modal-title create_tag">Thêm bài viết</h4>
        <h4 class="modal-title edit_tag">Cập nhật thông tin</h4>
        <input type="hidden" name="" id="idEditPost" value="">
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="post">Tên bài viết <span class="red-color">(*)</span></label>
            <input type="text" class="form-control" id="post" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="post">Chuyên mục <span class="red-color">(*)</span></label>
            <select id="category_id" class="form-control form-control-sm">
              @foreach ($category as $key => $val_cat)
              <option value="{{$val_cat['id']}}">{{$val_cat['category']}}</option>
              @endforeach
            </select>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="content">Nội dung <span class="red-color">(*)</span></label>
            <textarea class="form-control" id="content" rows="3"></textarea>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="status">Trạng thái <span class="red-color">(*)</span></label>
            <select id="status" class="form-control form-control-sm">
              <option value="0">Công khai</option>
              <option value="1">Riêng tư</option>
            </select>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="files">File đính kèm</label>

            <div class="form-group-sm group_file">
              <i class="fa fa-times-circle clear_file" aria-hidden="true" data-tooltip="tooltip" title="Hủy chọn"></i>

             <input type="file" accept="file_extension" class="form-control" id="files" placeholder="" value="">
             <p id="name_file"></p>
           </div>
        </div>
      </div>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-sm btn-success create_tag" id="add-post">Lưu</button>
        <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-post">Cập nhật</button>
      </center>
    </div>
  </div>
</div>
</div>

@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.2/tinymce.min.js" type="text/javascript"></script>

<script>
  var postTable = $('#post-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('post.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'30px'},
    {data: 'post', name: 'post', 'width':'150px'},
    {data: 'name', name: 'name'},
    {data: 'category', name: 'category', 'width':'88px'},
    {data: 'content', name: 'content', 'width':'300px', class:'dt-justify'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center'},
    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "90px", 'class':'dt-center'},
    ]
  });

  $('#files').prop('title', '');

  $('#createFrom').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();
    $('#name_file').hide();
    $('.clear_file').hide();

    $('#post').val('');
    $('#category_id').val(1);
    $('#status').val(0);
    $('#files').val('');
    tinyMCE.get('content').setContent('');
  });

  $('#files').change(function(){
    $('#name_file').hide();
    $('#files').prop('title', '');

    if($('#files').val() != ''){
      $('.clear_file').show();
    }else{
      $('.clear_file').hide();
    }
  });

  $('.clear_file').click(function(){
    $('#files').val('');
    $('.clear_file').hide();
    $('#name_file').hide();
  });

  function getData(){
    var post = $('#post').val();
    var category_id = $('#category_id').val();
    var content = tinyMCE.get('content').getContent();
    var status = $('#status').val();
    var files = ($('#files').val() != '')? $('#files')[0].files[0]: '';

    var post_data = new FormData();
    post_data.append('post', post);
    post_data.append('category_id', category_id);
    post_data.append('content', content);
    post_data.append('status', status);
    post_data.append('files', files);

    return post_data;
  }

  $('#add-post').click(function(){
    var post_data = getData();

    $.ajax({
      type: 'post',
      url: '{{ route('post.insert') }}',
      data: post_data,
      async:false,
      processData: false,
      contentType: false,
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm bài viết thành công!');
          $('#modalCreateEdit').modal('hide');
          postTable.ajax.reload(null,false);
        }else{
          if(res.message.post || res.message.content){
            if(res.message.post){
              toastr.error(res.message.post);
            }
            if(res.message.content){
              toastr.error(res.message.content);
            }
          }else{
            toastr.error(res.message);
          }
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });

  $(document).on('click', '.btn-delete', function () {

    var path = "{{URL::asset('')}}post/" + $(this).data('id');

    swal({
      title: "Bạn có chắc muốn xóa?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      cancelButtonText: "Không",
      confirmButtonText: "Có",
    },
    function(isConfirm) {
      if (isConfirm) {  

        $.ajax({
          type: "DELETE",
          url: path,
          success: function(res)
          {
            if(!res.error) {
              toastr.warning('Xóa thành công!');
              postTable.ajax.reload(null,false);     
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      } 
    });
  });

  function showEditPost(id){
    $('#modalCreateEdit').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();
    $('#name_file').hide();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}post/"+id+"",
      data: id,
      success: function(res){
        $('#post').val(res.post.post);
        $('#category_id').val(res.post.category_id);
        $('#status').val(res.post.status);
        tinyMCE.get('content').setContent(res.post.content);
        $('#idEditPost').val(id);

        if(res.post.files){
          $('#name_file').show();
          $('#name_file').html(res.post.files);
          $('.clear_file').show();
        }
      },
    });
  }

  $('#edit-post').click(function(){
    var id = $('#idEditPost').val();
    var post_data = getData();
    $('#name_file').html('');

    $.ajax({
      type: 'POST',
      url: "{{URL::asset('')}}post/"+id+"",
      data: post_data,
      async:false,
      processData: false,
      contentType: false,
      success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật bài viết thành công!");
          $('#modalCreateEdit').modal('hide');
          postTable.ajax.reload(null,false);
        }else{
          if(res.message.post || res.message.content){
            if(res.message.post){
              toastr.error(res.message.post);
            }
            if(res.message.content){
              toastr.error(res.message.content);
            }
          }else{
            toastr.error(res.message);
          }
        }
      },error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });

  tinymce.init({
    selector: 'textarea#content',
    height: 400,
    menubar: false,
    plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help imagetools wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image',
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tiny.cloud/css/codepen.min.css'
    ]
  });
</script>
@endsection