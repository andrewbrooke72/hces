<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestPaperQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_paper_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_star')->default(0);
            $table->string('type');
            $table->string('file_page_reference');
            $table->string('test_paper_id');
            $table->string('name');
            $table->longText('question');
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
        Schema::dropIfExists('test_paper_questions');
    }
}
