<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->boolean('is_admin')->default(0);
            $table->boolean('is_teacher')->default(0);
            $table->boolean('is_secretary')->default(0);
            $table->string('role')->nullable();
        });
    }

    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('is_admin');
            $table->dropColumn('is_teacher');
            $table->dropColumn('is_secretary');
            $table->dropColumn('role');
        });
    }
}
