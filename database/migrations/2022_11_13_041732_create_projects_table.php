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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('slug');
            $table->string('genre');
            $table->string('word_count');
            $table->string('seeking');
            $table->text('preview')->nullable();
            $table->string('content_link', 2048)->nullable();
            $table->string('feedback_type')->nullable();
            $table->text('similar_works')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('content_notices')->nullable();
            $table->text('query_letter')->nullable();
            $table->text('synopsis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
