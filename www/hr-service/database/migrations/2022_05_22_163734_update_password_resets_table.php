<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn(['email', 'created_at']);
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->integer('user_id')->index();
            $table->integer('time_requested');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'time_requested']);
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->timestamp('created_at')->nullable();
        });
    }
}
