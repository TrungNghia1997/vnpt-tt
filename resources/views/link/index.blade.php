@extends('layouts.master')

@section('header')

<style type="text/css" media="screen">
.image-preview-input {
  position: relative;
  overflow: hidden;
  margin: 0px;    
  color: #333;
  background-color: #fff;
  border-color: #ccc;    
}
.image-preview-input input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  padding: 0;
  font-size: 20px;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}
.image-preview-input-title {
  margin-left:2px;
}
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h3 class="mb-2">Quản lý chương trình liên kết</h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Quản trị</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chương trình liên kết</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5" style="margin-bottom: 15px;">
        <a data-toggle="modal" href="#modalCreateEdit" id="createFrom"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Thêm mới</button>
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="link-table">
            <thead>
              <tr>
               <th class="stl-column color-column">STT</th>
               <th class="stl-column color-column">Tên chương trình</th>
               <th class="stl-column color-column">Ảnh đại diện</th>
               <th class="stl-column color-column">Link liên kết</th>
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

      <div class="modal-header center">
        <h4 class="modal-title create_tag">Thêm chương trình liên kết</h4>
        <h4 class="modal-title edit_tag">Cập nhật thông tin</h4>
      </div>

      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="name_link">Tên chương trình <span class="red-color">(*)</span></label>
            <input type="text" class="form-control" id="name_link" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom ">
            <label for="avatar">Ảnh đại diện <span class="red-color">(*)</span></label>
            <div class="input-group image-preview">
              <input type="text" class="form-control form-control-sm image-preview-filename" disabled="disabled">
              <span class="input-group-btn">
                <!-- image-preview-clear button -->
                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                  <span class="glyphicon glyphicon-remove"></span> Xóa
                </button>
                <!-- image-preview-input -->
                <div class="btn btn-default image-preview-input">
                  <span class="glyphicon glyphicon-folder-open"></span>
                  <span class="image-preview-input-title">Chọn ảnh</span>
                  <input type="file" accept="image/png, image/jpeg, image/gif" id="avatar" name="input-file-preview"/> <!-- rename it -->
                </div>
              </span>
            </div>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="links">Link chương trình <span class="red-color">(*)</span></label>
            <input type="text" class="form-control" id="links" placeholder="http://" value="">
          </div>

        </div>
      </div>
      
      <div class="modal-footer">
        <input type="hidden" name="" id="idEditLink" value="">
        <center>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-sm btn-success create_tag" id="add-link">Lưu</button>
          <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-link">Cập nhật</button>
        </center>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')

<script>
  var linkTable = $('#link-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('link.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'20px'},
    {data: 'name', name: 'name'},
    {data: 'img', name: 'img', 'class':'dt-center', 'width':'150px'},
    {data: 'links', name: 'links'},
    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "16%", 'class':'dt-center'},
    ]
  });

  $('#createFrom').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();   

    $('#name_link').val('');
    $('#links').val('http://');
    resetImage();
  });

  function getData(){

    var image = ($('#avatar')[0].files[0])? $('#avatar')[0].files[0]: $('.image-preview-filename').val();
    var name  = $('#name_link').val();
    var links = $('#links').val();

    var form_data = new FormData();
    form_data.append('name', name);
    form_data.append('links', links);
    form_data.append('img', image);

    return form_data;
  }

  $('#add-link').click(function(){

    $.ajax({
      type: 'post',
      url: '{{ route('link.insert') }}',
      data: getData(),
      async:false,
      processData: false,
      contentType: false,
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm thành công!');
          $('#modalCreateEdit').modal('hide');
          linkTable.ajax.reload(null,false);
        }else{
          if(res.message.name || res.message.img || res.message.links){
            if(res.message.name){
              toastr.error(res.message.name);
            }
            if(res.message.img){
              toastr.error(res.message.img);
            }
            if(res.message.links){
              toastr.error(res.message.links);
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

    var path = "{{URL::asset('')}}link/" + $(this).data('id');

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
              linkTable.ajax.reload(null,false);     
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      } 
    });
  });

  function showEditLink(id){
    $('#modalCreateEdit').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}link/"+id+"",
      data: id,
      success: function(res){
        if(!res.error){
          $('#idEditLink').val(id);

          $('#name_link').val(res.link.name);
          $('#links').val(res.link.links);
          
          if(res.link.img != null){
            var img = $('<img/>', {
              id: 'dynamic',
              width:250,
              height:200
            });
            $(".image-preview-input-title").text("Thay đổi");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(res.link.img);            
            img.attr('src', '{{ asset('images') }}/'+res.link.img);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
          }
        }else{
          toastr.error(res.message);
        }
      },
    });
  }

  $('#edit-link').click(function(){
    var id = $('#idEditLink').val();
    var form_data = getData();

    $.ajax({
      type: 'post',
      url: "{{URL::asset('')}}link/"+id+"",
      data: form_data,
      async:false,
      contentType: false,
      processData: false,
      success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật thành công!");
          $('#modalCreateEdit').modal('hide');
          linkTable.ajax.reload(null,false);
        }else{
          if(res.message.name || res.message.img || res.message.links){
            if(res.message.name){
              toastr.error(res.message.name);
            }
            if(res.message.img){
              toastr.error(res.message.img);
            }
            if(res.message.links){
              toastr.error(res.message.links);
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

  //up ảnh
  $(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
      function () {
       $('.image-preview').popover('show');
     }, 
     function () {
       $('.image-preview').popover('hide');
     }
     );    
  });

  function resetImage(){
    $('.image-preview').attr("data-content","").popover('hide');
    $('.image-preview-filename').val("");
    $('.image-preview-clear').hide();
    $('.image-preview-input input:file').val("");
    $(".image-preview-input-title").text("Chọn ảnh");    
  };

  $(function() {
    // Create the close button
    var closebtn = $('<button/>', {
      type:"button",
      text: 'X',
      id: 'close-preview',
      style: 'font-size: initial;color:black !important;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
      trigger:'manual',
      html:true,
      title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
      content: "Chưa có ảnh nào",
      placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
      resetImage();
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
      var img = $('<img/>', {
        id: 'dynamic',
        width:250,
        height:200
      });      
      var file = this.files[0];
      var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
          $(".image-preview-input-title").text("Thay đổi");
          $(".image-preview-clear").show();
          $(".image-preview-filename").val(file.name);            
          img.attr('src', e.target.result);
          $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
      });

  });

</script>
@endsection