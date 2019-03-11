@extends('layouts.master')

@section('header')
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
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="page-header">
      <h3 class="mb-2">Danh bạ nhân viên </h3>
      <div class="page-breadcrumb">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">Menu</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh bạ</li>
          </ol>
        </nav>
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
             </tr>
           </thead>
         </table>
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

</script>
@endsection