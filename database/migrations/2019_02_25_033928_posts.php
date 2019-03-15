<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('post')->comment('Tên bài viết');
            $table->text('content')->comment('Nội dung bài viết');
            $table->integer('user_id')->comment('Id người đăng');
            $table->integer('category_id')->comment('Id chuyên mục');
            $table->tinyInteger('status')->comment('Trạng thái bài viết: 1 - private(bắt đăng nhập để xem); 0 - public')->default(0);
            $table->string('files')->comment('File đính kèm')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
