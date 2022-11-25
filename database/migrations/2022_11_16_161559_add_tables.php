<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cv', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('phone');
            $table->string('email');
        });

        Schema::create('education_progress', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('educational_institution', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('faculty');
            $table->foreignId('cv_id')->constrained('cv')->cascadeOnDelete();
        });

        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('educational_level');
            $table->string('field_of_study');
            $table->unsignedMediumInteger('time_spent_in_studies');
            $table->foreignId('educational_institution_id')->constrained('educational_institution')->cascadeOnDelete();
            $table->foreignId('education_progress_id')->constrained('education_progress');
        });

        Schema::create('accomplishment_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('workplace', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('cv_id')->constrained('cv')->cascadeOnDelete();
        });

        Schema::create('job_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('workplace_position', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedMediumInteger('employment_length'); // months
            $table->foreignId('workplace_id')->constrained('workplace')->cascadeOnDelete();
            $table->foreignId('job_type_id')->constrained('job_type');
        });

        Schema::create('workplace_position_accomplishment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('workplace_position_id')->constrained('workplace_position')->cascadeOnDelete();
            $table->foreignId('accomplishment_type_id')->constrained('accomplishment_type');
        });

        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('index');
            $table->string('city')->nullable();
            $table->string('parish')->nullable();
            $table->string('village')->nullable();
            $table->string('street')->nullable();
            $table->string('building');
            $table->foreignId('cv_id')->constrained('cv')->cascadeOnDelete();
            $table->foreignId('country_id')->constrained('country');
        });
    }

    public function down()
    {
        Schema::drop('education');
        Schema::drop('educational_institution');
        Schema::drop('workplace_position_accomplishment');
        Schema::drop('workplace_position');
        Schema::drop('workplace');
        Schema::drop('address');
        Schema::drop('country');
        Schema::drop('cv');
        Schema::drop('job_type');
        Schema::drop('accomplishment_type');
        Schema::drop('education_progress');
    }
};
