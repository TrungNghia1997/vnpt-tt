@extends('layouts.master')

@section('header')

@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h3 class="mb-2">Quản lý chuyên mục </h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Quản trị</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chuyên mục</li>
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
          <table class="table table-striped table-bordered table-hover" id="category-table">
            <thead>
              <tr>
               <th class="stl-column color-column">STT</th>
               <th class="stl-column color-column">Tên chuyên mục</th>
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
        <h4 class="modal-title create_tag">Thêm chuyên mục</h4>
        <h4 class="modal-title edit_tag">Cập nhật chuyên mục</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <label for="category">Chuyên mục</label>
            <input type="text" class="form-control" id="category" placeholder="" value="">
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="hidden" name="" id="idEditCategory" value="">
        <center>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-sm btn-success create_tag" id="add-category">Lưu</button>
          <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-category">Cập nhật</button>
        </center>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
<script>
  var categoryTable = $('#category-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('category.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'50px'},
    {data: 'category', name: 'category'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center'},
    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", 'class':'dt-center'},
    ]
  });

  $('#createFrom').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();

    $('#category').val('');
  });

  $('#add-category').click(function(){
    var category = $('#category').val();

    $.ajax({
      type: 'post',
      url: '{{ route('category.insert') }}',
      data: {
        category: category,
      },
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm chuyên mục thành công!');
          $('#modalCreateEdit').modal('hide');
          categoryTable.ajax.reload(null,false);
        }else{
          toastr.error(res.message);
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });

  $(document).on('click', '.btn-delete', function () {

    var path = "{{URL::asset('')}}category/" + $(this).data('id');

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
              categoryTable.ajax.reload(null,false);     
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      } 
    });
  });

  function showEditCategory(id){
    $('#modalCreateEdit').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}category/"+id+"",
      data: id,
      success: function(res){
        $('#category').val(res.category.category);
        $('#idEditCategory').val(id);
      },
    });
  }

  $('#edit-category').click(function(){
    var id = $('#idEditCategory').val();

    $.ajax({
      type: 'PUT',
      url: "{{URL::asset('')}}category/"+id+"",
      data: {
        category: $('#category').val(),
      },success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật chuyên mục thành công!");
          $('#modalCreateEdit').modal('hide');
          categoryTable.ajax.reload(null,false);
        }else{
          toastr.error(res.message);
        }
      },error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });
</script>
@endsection