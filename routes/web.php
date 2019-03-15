<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

//Quản lý nhân viên
Route::get('user', 'User\UserController@index')->name('user.index');
Route::get('get-list-user', 'User\UserController@getListUser')->name('user.getList');
Route::post('insert-user', 'User\UserController@store')->name('user.insert');
Route::delete('user/{id}', 'User\UserController@destroy')->name('user.delete');
Route::get('user/{id}', 'User\UserController@show')->name('user.show');
Route::post('user/{id}', 'User\UserController@update')->name('user.update');
Route::get('get-role-user', 'User\UserController@getListRoleUser')->name('user.roleUser');
Route::post('add-del-role-user', 'User\UserController@addDelRole')->name('user.addDelRole');

//Quản lý chuyên mục
Route::get('category', 'Category\CategoryController@index')->name('category.index');
Route::get('get-list-category', 'Category\CategoryController@getListCategory')->name('category.getList');
Route::post('insert-category', 'Category\CategoryController@store')->name('category.insert');
Route::delete('category/{id}', 'Category\CategoryController@destroy')->name('category.delete');
Route::get('category/{id}', 'Category\CategoryController@show')->name('category.show');
Route::put('category/{id}', 'Category\CategoryController@update')->name('category.update');

//Quản lý bộ phận
Route::get('department', 'Department\DepartmentController@index')->name('department.index');
Route::get('get-list-department-group', 'Department\DepartmentController@getListDepartmentGroup')->name('department.getList');
Route::get('get-list-department', 'Department\DepartmentController@getListDepartment')->name('department.getListDepartment');
Route::post('insert-department', 'Department\DepartmentController@store')->name('department.insert');
Route::delete('department/{id}', 'Department\DepartmentController@destroy')->name('department.delete');
Route::get('department/{id}', 'Department\DepartmentController@show')->name('department.show');
Route::post('department/{id}', 'Department\DepartmentController@update')->name('department.update');

//Quản lý quyền hạn
Route::get('permission', 'Permission\PermissionController@index')->name('permission.index');
Route::get('get-list-permission', 'Permission\PermissionController@getListPermission')->name('permission.getList');
Route::post('insert-permission', 'Permission\PermissionController@store')->name('permission.insert');
Route::delete('permission/{id}', 'Permission\PermissionController@destroy')->name('permission.delete');
Route::get('permission/{id}', 'Permission\PermissionController@show')->name('permission.show');
Route::put('permission/{id}', 'Permission\PermissionController@update')->name('permission.update');

//Quản lý vai trò
Route::get('role', 'Role\RoleController@index')->name('role.index');
Route::get('get-list-role', 'Role\RoleController@getListRole')->name('role.getList');
Route::get('get-role-permission', 'Role\RoleController@getListRolePermission')->name('role.rolePermission');
Route::post('insert-role', 'Role\RoleController@store')->name('role.insert');
Route::delete('role/{id}', 'Role\RoleController@destroy')->name('role.delete');
Route::get('role/{id}', 'Role\RoleController@show')->name('role.show');
Route::put('role/{id}', 'Role\RoleController@update')->name('role.update');
Route::post('add-del-role-permission', 'Role\RoleController@addDelPermission')->name('role.addDelPermission');

//Quản lý bài viết
Route::get('post', 'Post\PostController@index')->name('post.index');
Route::get('get-list-post', 'Post\PostController@getListPost')->name('post.getList');
Route::post('insert-post', 'Post\PostController@store')->name('post.insert');
Route::delete('post/{id}', 'Post\PostController@destroy')->name('post.delete');
Route::get('post/{id}', 'Post\PostController@show')->name('post.show');
Route::post('post/{id}', 'Post\PostController@update')->name('post.update');
Route::get('post/{post}', 'Post\PostController@postDetail')->name('post.detail');

//Danh bạ nội bộ
Route::get('contact-user', 'User\UserController@contactUser')->name('contactUser.index');
Route::get('get-list-contact-user', 'User\UserController@getListContactUser')->name('contactUser.getList');