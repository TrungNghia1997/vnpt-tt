<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedAtAndUpdatedAtToLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            if (!Schema::hasColumn('links', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            if (Schema::hasColumn('links', 'created_at')) {
                $table->dropColumn('created_at');
            }

            if (Schema::hasColumn('links', 'updated_at')) {
                $table->dropColumn('updated_at');
            }

        });
    }
}
