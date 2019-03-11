@extends('layouts.master')

@section('header')

@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h3 class="mb-2">Quản lý vai trò </h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Quản trị</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vai trò</li>
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
          <table class="table table-striped table-bordered table-hover" id="role-table">
            <thead>
              <tr>
               <th class="stl-column color-column">STT</th>
               <th class="stl-column color-column">Vai trò</th>
               <th class="stl-column color-column">Tên hiển thị</th>
               <th class="stl-column color-column">Mô tả</th>
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
        <h4 class="modal-title create_tag">Thêm vai trò</h4>
        <h4 class="modal-title edit_tag">Cập nhật thông tin</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="name">Vai trò</label>
            <input type="text" class="form-control" id="name" placeholder="" value="">
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="display_name">Tên hiển thị</label>
            <input type="text" class="form-control" id="display_name" placeholder="" value="">
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <input type="hidden" name="" id="role-id" value="">
        <center>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-sm btn-success create_tag" id="add-role">Lưu</button>
          <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-role">Cập nhật</button>
        </center>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDetail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header center">
        <h4 class="modal-title">Thêm quyền hạn</h4>
      </div>

      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="permission-table">
              <thead>
                <tr>
                 <th class="stl-column color-column">STT</th>
                 <th class="stl-column color-column">Quyền hạn</th>
                 <th class="stl-column color-column">Tên hiển thị</th>
                 <th class="stl-column color-column">Mô tả</th>
                 <th class="stl-column color-column">Ngày tạo</th>
                 <th class="stl-column color-column">Hành động</th>
               </tr>
             </thead>
           </table>
         </div>
       </div>
     </div>

     <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Đóng</button>
      </center>
    </div>
  </div>
</div>
</div>
@endsection

@section('footer')
<script>
  var roleTable = $('#role-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('role.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'50px'},
    {data: 'name', name: 'name'},
    {data: 'display_name', name: 'display_name', 'width':'150px'},
    {data: 'description', name: 'description'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center'},
    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "20%", 'class':'dt-center'},
    ]
  });

  $('#createFrom').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();

    $('#name').val('');
    $('#display_name').val('');
    $('#description').val('');
  });

  $('#add-role').click(function(){
    var role = $('#name').val();
    var display_name = $('#display_name').val();
    var description = $('#description').val();

    $.ajax({
      type: 'post',
      url: '{{ route('role.insert') }}',
      data: {
        name: role,
        description: description,
        display_name: display_name,
      },
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm vai trò thành công!');
          $('#modalCreateEdit').modal('hide');
          roleTable.ajax.reload(null,false);
        }else{
          if(res.message.name){
            toastr.error(res.message.name);
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

    var path = "{{URL::asset('')}}role/" + $(this).data('id');

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
              roleTable.ajax.reload(null,false);     
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      } 
    });
  });

  function showEditRole(id){
    $('#modalCreateEdit').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}role/"+id+"",
      data: id,
      success: function(res){
        $('#name').val(res.role.name);
        $('#display_name').val(res.role.display_name);
        $('#description').html(res.role.description);
        $('#role-id').val(id);
      },
    });
  }

  $('#edit-role').click(function(){
    var id = $('#role-id').val();

    $.ajax({
      type: 'PUT',
      url: "{{URL::asset('')}}role/"+id+"",
      data: {
        name: $('#name').val(),
        display_name: $('#display_name').val(),
        description: $('#description').val(),
      },success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật vai trò thành công!");
          $('#modalCreateEdit').modal('hide');
          roleTable.ajax.reload(null,false);
        }else{
          if(res.message.name){
            toastr.error(res.message.name);
          }else{
            toastr.error(res.message);
          }
        }
      },error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });

  function showDetailRole(id){
    $('#modalDetail').modal('show');
    $('#permission-table').DataTable().destroy();

    var permissionTable = $('#permission-table').DataTable({
      processing: true,
      serverSide: true,
      ordering: false,
      order: [], 
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      ajax: {
        type: 'GET',
        url: '{!! route('role.rolePermission') !!}',
        data: {
          id: id,
        },
      },
      columns: [
      {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'20px'},
      {data: 'name', name: 'name'},
      {data: 'display_name', name: 'display_name'},
      {data: 'description', name: 'description', 'width':'250px'},
      {data: 'created_at', name: 'created_at', 'class':'dt-center'},
      {data: 'action', name: 'action', orderable: false, searchable: false, "width": "10%", 'class':'dt-center'},
      ]
    });
  }

  function addRolePermission(role_id, permission_id, type){
    var type = 0;
    if($('#select'+permission_id).prop('checked')){
      $('#select'+permission_id).attr('data-original-title', 'Bỏ quyền hạn');
      type = 1;
    }else{
      $('#select'+permission_id).attr('data-original-title', 'Chọn quyền hạn');
      type = 0;
    }

    $.ajax({
      type: 'POST',
      url: '{{ route('role.addDelPermission') }}',
      data: {
        role_id: role_id,
        permission_id: permission_id,
        type: type,
      },success: function(res){
        if(!res.error){
          if(res.type == 1){
            toastr.success('Thêm quyền hạn thành công');
          }else{
            toastr.success('Bỏ quyền hạn thành công');
          }
        }else{
          toastr.error(res.message);
        }
      },
    });
  }
</script>
@endsection