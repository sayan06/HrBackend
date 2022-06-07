<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_informations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('DOB');
            $table->double('height_feet');
            $table->double('height_inches');
            $table->integer('degree_id');
            $table->integer('ethnicity_id');
            $table->integer('eye_color_id');
            $table->integer('alcohol_consumption_type_id');
            $table->integer('hair_color_id');
            $table->integer('religion_id');
            $table->integer('astrological_sign_id');
            $table->integer('kids_requirement_type_id');
            $table->integer('body_style_id');
            $table->integer('marital_status_id');
            $table->string('country');
            $table->string('city');
            $table->string('gender');
            $table->string('about');
            $table->string('company_name');
            $table->string('high_school_name');
            $table->string('college_name');
            $table->string('job_title');
            $table->boolean('is_hidden');
            $table->boolean('smoker');
            $table->boolean('kids');
            $table->integer('steps');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('user_informations', function (Blueprint $table) {
            $table->integer('created_at')->nullable()->change();
            $table->integer('updated_at')->nullable()->change();
            $table->integer('deleted_at')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_informations');
    }
};
