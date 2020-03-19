<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('employee_id');
            $table->unsignedBigInteger('shift_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->date('date_of_birth');
            $table->integer('age');
            $table->string('permanent_address');
            $table->integer('length_of_service_years')->nullable()->default(0);
            $table->integer('length_of_service_years_months')->nullable()->default(0);
            $table->string('length_of_service')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('other_contact_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique('employee_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('shift_id')->references('id')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
