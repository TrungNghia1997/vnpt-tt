@extends('layouts.master')

@section('header')
<link rel="stylesheet" href="{{ asset('/vendor/inputmask/css/inputmask.css') }}" />

@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h3 class="mb-2">Quản lý nhóm bộ phận </h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Quản trị</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nhóm bộ phận</li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5" style="margin-bottom: 15px;">
        {{-- @if (Entrust::can(["slides-add"])) --}}
        <a data-toggle="modal" href="#modalCreateEdit" id="createFrom"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Thêm nhóm bộ phận</button>
        </a>
        {{-- @endif --}}
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="department-group-table">
            <thead>
              <tr>
               <th class="stl-column color-column">STT</th>
               <th class="stl-column color-column">Tên nhóm</th>
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

      <div class="modal-header center">
        <h4 class="modal-title create_tag">Thêm nhóm bộ phận</h4>
        <h4 class="modal-title edit_tag">Cập nhật thông tin</h4>
      </div>

      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="department_group">Tên nhóm <span class="red-color">(*)</span></label>
            <input type="text" class="form-control" id="department_group" placeholder="" value="">
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <input type="hidden" name="" id="idEditDepartmentGroup" value="">
        <center>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-sm btn-success create_tag" id="add-department-group">Lưu</button>
          <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-department-group">Cập nhật</button>
        </center>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDetail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header center">
        <h4 class="modal-title">Quản lý bộ phận</h4>
      </div>

      <div class="modal-body">
        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5" style="margin-bottom: 15px;">
          {{-- @if (Entrust::can(["slides-add"])) --}}
          <a data-toggle="modal" href="#modalCreateEditDepartment" id="createFromDepartment"><button class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Thêm bộ phận</button>
          </a>
          {{-- @endif --}}
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="department-table">
              <thead>
                <tr>
                 <th class="stl-column color-column">STT</th>
                 <th class="stl-column color-column">Bộ phận</th>
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

<div class="modal" id="modalCreateEditDepartment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header center">
        <h4 class="modal-title create_tag">Thêm bộ phận</h4>
        <h4 class="modal-title edit_tag">Cập nhật thông tin</h4>
      </div>

      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="department">Bộ phận <span class="red-color">(*)</span></label>
            <input type="text" class="form-control" id="department" placeholder="" value="">
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <input type="hidden" name="" id="id-edit-department" value="">
        <input type="hidden" name="" id="parent-id" value="">
        <center>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-sm btn-success create_tag" id="add-department">Lưu</button>
          <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-department">Cập nhật</button>
        </center>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<script src="{{ asset('/vendor/inputmask/js/jquery.inputmask.bundle.js') }}"></script>

<script>
  var departmentGroupTable = $('#department-group-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('department.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'20px'},
    {data: 'department', name: 'department'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center'},
    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "16%", 'class':'dt-center'},
    ]
  });

  $('#department-table').DataTable();

  $('#createFrom').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();   

    $('#department_group').val('');
  });

  $('#createFromDepartment').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();   

    $('#department').val('');
  });

  $('#add-department-group').click(function(){

    $.ajax({
      type: 'post',
      url: '{{ route('department.insert') }}',
      data: {
        department: $('#department_group').val(),
      },
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm nhóm bộ phận thành công!');
          $('#modalCreateEdit').modal('hide');
          departmentGroupTable.ajax.reload(null,false);
        }else{
          if(res.message.department){
            toastr.error(res.message.department);
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

    var path = "{{URL::asset('')}}department/" + $(this).data('id');

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
              departmentGroupTable.ajax.reload(null,false); 
              $('#department-table').DataTable().ajax.reload(null,false);    
            }else{
              toastr.error(res.message);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      } 
    });
  });

  function showEditDepartmentGroup(id){
    $('#modalCreateEdit').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}department/"+id+"",
      success: function(res){
        if(!res.error){
          $('#department_group').val(res.department.department);
          $('#idEditDepartmentGroup').val(id);
        }else{
          toastr.error(res.message);
        }
      },
    });
  }

  $('#edit-department-group').click(function(){
    var id = $('#idEditDepartmentGroup').val();

    $.ajax({
      type: 'post',
      url: "{{URL::asset('')}}department/"+id+"",
      data: {
        department: $('#department_group').val(),
      },
      success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật nhóm bộ phận thành công!");
          $('#modalCreateEdit').modal('hide');
          departmentGroupTable.ajax.reload(null,false);
        }else{
          if(res.message.department){
            toastr.error(res.message.department);
          }else{
            toastr.error(res.message);
          }
        }
      },error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });

  function showDetailDepartmentGroup(id){
    $('#modalDetail').modal('show');
    $('#department-table').DataTable().destroy();
    $('#parent-id').val(id);

    var departmentTable = $('#department-table').DataTable({
      processing: true,
      serverSide: true,
      ordering: false,
      order: [], 
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      ajax: {
        type: 'GET',
        url: '{{ route('department.getListDepartment') }}',
        data: {
          id: id,
        },
      },
      columns: [
      {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'20px'},
      {data: 'department', name: 'department'},
      {data: 'created_at', name: 'created_at', 'class':'dt-center'},
      {data: 'action', name: 'action', orderable: false, searchable: false, "width": "16%", 'class':'dt-center'},
      ]
    });
  }

  $('#add-department').click(function(){
    var parent_id = $('#parent-id').val();

    $.ajax({
      type: 'post',
      url: '{{ route('department.insert') }}',
      data: {
        department: $('#department').val(),
        parent_id: parent_id,
      },
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm bộ phận thành công!');
          $('#modalCreateEditDepartment').modal('hide');
          $('#department-table').DataTable().ajax.reload(null,false);
        }else{
          if(res.message.department){
            toastr.error(res.message.department);
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

  function showEditDepartment(id){
    $('#modalCreateEditDepartment').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}department/"+id+"",
      success: function(res){
        if(!res.error){
          $('#department').val(res.department.department);
          $('#id-edit-department').val(id);
          $('#parent-id').val(res.department.parent_id);
        }else{
          toastr.error(res.message);
        }
      },
    });
  }

  $('#edit-department').click(function(){
    var id = $('#id-edit-department').val();
    var parent_id = $('#parent-id').val();

    $.ajax({
      type: 'post',
      url: "{{URL::asset('')}}department/"+id+"",
      data: {
        department: $('#department').val(),
        parent_id: parent_id,
      },
      success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật bộ phận thành công!");
          $('#modalCreateEditDepartment').modal('hide');
          $('#department-table').DataTable().ajax.reload(null,false);
        }else{
          if(res.message.department){
            toastr.error(res.message.department);
          }else{
            toastr.error(res.message);
          }
        }
      },error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });
</script>
@endsection