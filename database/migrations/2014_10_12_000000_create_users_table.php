<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Tên nhân viên');
            $table->string('password', 255)->comment('Mật khẩu');
            $table->string('avatar')->comment('Ảnh đại diện')->nullable();
            $table->string('email')->unique()->comment('Email nhân viên');
            $table->string('phone', 11)->comment('Số điện thoại nhân viên');
            $table->date('birthday')->comment('Ngày sinh nhân viên')->nullable();
            $table->tinyInteger('gender')->comment('Giới tính: 1 - nam; 0 - nữ')->default(1);
            $table->string('job')->comment('Chức vụ trong phòng ban')->nullable();
            $table->integer('department_id')->comment('Id phòng ban')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
