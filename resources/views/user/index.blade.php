@extends('layouts.master')

@section('header')
<link rel="stylesheet" href="{{ asset('/vendor/inputmask/css/inputmask.css') }}" />
<style type="text/css" media="screen">
.mdi{
  font-size: 17px;
}
.mdi-gender-male{
  color: blue;
}
.mdi-gender-female{
  color: #f9002bd9;
}
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
      <h3 class="mb-2">Quản lý nhân viên </h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Quản trị</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nhân viên</li>
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
          <table class="table table-striped table-bordered table-hover" id="user-table">
            <thead>
              <tr>
               <th class="stl-column color-column">STT</th>
               <th class="stl-column color-column">Họ tên</th>
               <th class="stl-column color-column">Giới tính</th>
               <th class="stl-column color-column">Email</th>
               <th class="stl-column color-column">Điện thoại</th>
               <th class="stl-column color-column">Địa chỉ</th>
               <th class="stl-column color-column">Chức vụ</th>
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
        <h4 class="modal-title create_tag">Thêm nhân viên</h4>
        <h4 class="modal-title edit_tag">Cập nhật thông tin</h4>
      </div>

      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="name_user">Họ tên <span class="red-color">(*)</span></label>
            <input type="text" class="form-control" id="name_user" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="email">Email <span class="red-color">(*)</span></label>
            <input type="email" class="form-control" id="email_user" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="phone">Điện thoại <span class="red-color">(*)</span></label>
            <input type="text" class="form-control phone-inputmask" id="phone" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control" id="address" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="gender" style="margin-right: 5px;">Giới tính </label>
            <label class="custom-control custom-radio custom-control-inline">
              <input type="radio" name="radio-inline" id="male" value="1" checked="" class="custom-control-input"><span class="custom-control-label">Nam</span>
            </label>
            <label class="custom-control custom-radio custom-control-inline">
              <input type="radio" name="radio-inline" id="female" value="0" class="custom-control-input"><span class="custom-control-label">Nữ</span>
            </label>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="birthday">Ngày sinh</label>
            <input type="text" class="form-control" id="birthday" placeholder="dd-mm-yyyy" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="job">Chức vụ</label>
            <input type="text" class="form-control" id="job" placeholder="" value="">
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom">
            <label for="department">Bộ phận</label>
            <select class="form-control form-control-sm selectpicker" id="department">
              @if(!empty($department))
              @foreach($department as $key => $val_de)
              @if($val_de['parent_id'] == '')
              <optgroup label="{{$val_de['department']}}">
                @foreach($department as $key => $de_item)
                @if($de_item['parent_id'] != '' && $de_item['parent_id'] == $val_de['id'])
                <option value="{{$de_item['id']}}">{{$de_item['department']}}</option>
                @endif
                @endforeach
              </optgroup>
              @endif
              @endforeach
              @else
              <option value="null">Chưa có bộ phận nào</option>
              @endif
            </select>
          </div>

          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 margin_bottom ">
            <label for="avatar">Avatar</label>
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
        </div>
      </div>
      
      <div class="modal-footer">
        <input type="hidden" name="" id="idEditUser" value="">
        <center>
          <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-sm btn-success create_tag" id="add-user">Lưu</button>
          <button type="button" class="btn btn-sm btn-warning edit_tag" id="edit-user">Cập nhật</button>
        </center>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDetail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header center">
        <h4 class="modal-title">Thông tin nhân viên</h4>
      </div>

      <div class="modal-body">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <table class="table table-bordered table-hover">
              <tr>
                <th>Họ tên</th>
                <td id="user_name"></td>
              </tr>
              <tr>
                <th>Avatar</th>
                <td id="user_avatar"></td>
              </tr>
              <tr>
                <th>Email</th>
                <td id="user_email"></td>
              </tr>
              <tr>
                <th>Điện thoại</th>
                <td id="user_phone"></td>
              </tr>
              <tr>
                <th>Địa chỉ</th>
                <td id="user_address"></td>
              </tr>
              <tr>
                <th>Giới tính</th>
                <td id="user_gender"></td>
              </tr>
              <tr>
                <th>Sinh nhật</th>
                <td id="user_birthday"></td>
              </tr>
              <tr>
                <th>Chức vụ</th>
                <td id="user_job"></td>
              </tr>
              <tr>
                <th>Bộ phận</th>
                <td id="user_department"></td>
              </tr>
          </table>
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

<div class="modal" id="modalDetailRole">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header center">
        <h4 class="modal-title">Thêm vai trò</h4>
      </div>

      <div class="modal-body">
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
<script src="{{ asset('/vendor/inputmask/js/jquery.inputmask.bundle.js') }}"></script>

<script>
  var userTable = $('#user-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [], 
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: '{!! route('user.getList') !!}',
    columns: [
    {data: 'DT_RowIndex', orderable: false, searchable: false, 'class':'dt-center', 'width':'20px'},
    {data: 'name', name: 'name'},
    {data: 'gender', name: 'gender', 'class':'dt-center', 'width':'57px'},
    {data: 'email', name: 'email'},
    {data: 'phone', name: 'phone', 'class':'dt-right'},
    {data: 'address', name: 'address'},
    {data: 'job', name: 'job', 'class':'dt-center'},
    {data: 'created_at', name: 'created_at', 'class':'dt-center'},
    {data: 'action', name: 'action', orderable: false, searchable: false, "width": "16%", 'class':'dt-center'},
    ]
  });

  $(".phone-inputmask").inputmask("(999) 999-9999");

  $('#createFrom').click(function(){
    $('.create_tag').show();
    $('.edit_tag').hide();   

    $('#name_user').val('');
    $('#email_user').val('');
    $('#phone').val('');
    $('#address').val('');
    $('#male').prop('checked', true);
    $('#birthday').val('');
    $('#job').val('');
    $('#department').val(0);
    resetImage();
  });

  function getData(){
    var gender = 1;
    if($('#male').prop('checked')){
      gender = $('#male').val();
    }else{
      gender = $('#female').val();
    }

    var image = ($('#avatar')[0].files[0])? $('#avatar')[0].files[0]: $('.image-preview-filename').val();
    var name  = $('#name_user').val();
    var email = $('#email_user').val();
    var phone = $(".phone-inputmask").val().toString().replace(/[()]/g, '').replace(/-/, '').replace(' ', '');
    var address = $('#address').val();
    var birthday = $('#birthday').val();
    var job = $('#job').val();
    var department = ($('#department').val())? $('#department').val(): '';

    var form_data = new FormData();
    form_data.append('name', name);
    form_data.append('email', email);
    form_data.append('phone', phone);
    form_data.append('address', address);
    form_data.append('birthday', birthday);
    form_data.append('job', job);
    form_data.append('department_id', department);
    form_data.append('gender', gender);
    form_data.append('avatar', image);

    return form_data;
  }

  $('#add-user').click(function(){

    $.ajax({
      type: 'post',
      url: '{{ route('user.insert') }}',
      data: getData(),
      async:false,
      processData: false,
      contentType: false,
      success: function(res){
        if(!res.error){
          toastr.success('Bạn đã thêm nhân viên thành công!');
          $('#modalCreateEdit').modal('hide');
          userTable.ajax.reload(null,false);
        }else{
          if(res.message.name || res.message.email || res.message.phone){
            if(res.message.name){
              toastr.error(res.message.name);
            }
            if(res.message.email){
              toastr.error(res.message.email);
            }
            if(res.message.phone){
              toastr.error(res.message.phone);
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

    var path = "{{URL::asset('')}}user/" + $(this).data('id');

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
              userTable.ajax.reload(null,false);     
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      } 
    });
  });

  function showEditUser(id){
    $('#modalCreateEdit').modal('show');
    $('.create_tag').hide();
    $('.edit_tag').show();

    $.ajax({
      method: 'GET',
      url: "{{URL::asset('')}}user/"+id+"",
      data: id,
      success: function(res){
        if(!res.error){
          $('#idEditUser').val(id);
          if(res.user.gender == 1){
            $('#male').prop('checked', true);
          }else{
            $('#female').prop('checked', true);
          }

          $('#name_user').val(res.user.name);
          $('#email_user').val(res.user.email);
          $('#phone').val(res.user.phone);
          (res.user.address!='')? $('#address').val(res.user.address): '';
          (res.user.birthday!='')? $('#birthday').val(res.user.birthday): '';
          (res.user.job!='')? $('#job').val(res.user.job): '';
          (res.user.department_id!='')? $('#department').val(res.user.department_id): '';
          
          if(res.user.avatar != null){
            var img = $('<img/>', {
              id: 'dynamic',
              width:250,
              height:200
            });
            $(".image-preview-input-title").text("Thay đổi");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(res.user.avatar);            
            img.attr('src', '{{ asset('images') }}/'+res.user.avatar);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
          }
        }else{
          toastr.error(res.message);
        }
      },
    });
  }

  $('#edit-user').click(function(){
    var id = $('#idEditUser').val();
    var form_data = getData();

    $.ajax({
      type: 'post',
      url: "{{URL::asset('')}}user/"+id+"",
      data: form_data,
      async:false,
      contentType: false,
      processData: false,
      success: function(res){
        if(!res.error){
          toastr.success("Bạn đã cập nhật nhân viên thành công!");
          $('#modalCreateEdit').modal('hide');
          userTable.ajax.reload(null,false);
        }else{
          if(res.message.name || res.message.email || res.message.phone){
            if(res.message.name){
              toastr.error(res.message.name);
            }
            if(res.message.email){
              toastr.error(res.message.email);
            }
            if(res.message.phone){
              toastr.error(res.message.phone);
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

  function showDetailUser(id){
    $('#modalDetail').modal('show');

    $.ajax({
      type: 'GET',
      url: "{{URL::asset('')}}user/"+id+"",
      success: function(res){
        if(!res.error){
          $('#user_name').html(res.user.name);
          (res.user.avatar!=null)? $('#user_avatar').html('<img src="{{ asset('images') }}/'+res.user.avatar+'" width="100px">') : $('#user_avatar').html('Chưa cập nhật');
          $('#user_email').html('<a href="mailto:'+res.user.email+'">'+res.user.email+'</a>');
          $('#user_phone').html('<a href="call:'+res.user.phone+'">'+res.user.phone+'</a>');
          (res.user.address!=null)? $('#user_address').html(res.user.address): $('#user_address').html('Chưa cập nhật');
          if(res.user.gender == 1){
            $('#user_gender').html('<i class="mdi mdi-gender-male" data-tooltip="tooltip" title="Nam"></i>');
          }else{
            $('#user_gender').html('<i class="mdi mdi-gender-female" data-tooltip="tooltip" title="Nữ"></i>');
          }
          (res.user.birthday!=null)? $('#user_birthday').html(res.user.birthday): $('#user_birthday').html('Chưa cập nhật');
          (res.user.job!=null)? $('#user_job').html(res.user.job): $('#user_job').html('Chưa cập nhật');
          
          var string = '';
          if(res.user.department_id != null){
            for(var department of res.user.department){
              string = string + '<p>'+department+'</p>';
            }
          }else{
            string = '<p>'+res.user.department+'</p>';
          }

          $('#user_department').html(string);
        }else{
          toastr.error(res.message);
        }
      }
    });
  }

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

  //add role
  function showDetailRole(id){
    $('#modalDetailRole').modal('show');
    $('#role-table').DataTable().destroy();

    var permissionTable = $('#role-table').DataTable({
      processing: true,
      serverSide: true,
      ordering: false,
      order: [], 
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      ajax: {
        type: 'GET',
        url: '{!! route('user.roleUser') !!}',
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

  function addRoleUser(user_id, role_id){
    var type = 0;
    if($('#select'+role_id).prop('checked')){
      $('#select'+role_id).attr('data-original-title', 'Bỏ vai trò');
      type = 1;
    }else{
      $('#select'+role_id).attr('data-original-title', 'Chọn vai trò');
      type = 0;
    }

    $.ajax({
      type: 'POST',
      url: '{{ route('user.addDelRole') }}',
      data: {
        role_id: role_id,
        user_id: user_id,
        type: type,
      },success: function(res){
        if(!res.error){
          if(res.type == 1){
            toastr.success('Thêm vai trò thành công');
          }else{
            toastr.success('Bỏ vai trò thành công');
          }
        }else{
          toastr.error(res.message);
        }
      },
    });
  }
</script>
@endsection