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
            $table->integer('user_id')->nullable();
            $table->integer('DOB')->nullable();
            $table->double('height_feet')->nullable();
            $table->double('height_inches')->nullable();
            $table->integer('degree_id')->nullable();
            $table->integer('ethnicity_id')->nullable();
            $table->integer('eye_color_id')->nullable();
            $table->integer('alcohol_consumption_type_id')->nullable();
            $table->integer('hair_color_id')->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('astrological_sign_id')->nullable();
            $table->integer('kids_requirement_type_id')->nullable();
            $table->integer('body_style_id')->nullable();
            $table->integer('marital_status_id')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('gender')->nullable();
            $table->string('about')->nullable();
            $table->string('company_name')->nullable();
            $table->string('high_school_name')->nullable();
            $table->string('college_name')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('is_hidden')->nullable();
            $table->boolean('smoker')->nullable();
            $table->boolean('kids')->nullable();
            $table->integer('steps')->nullable();
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
