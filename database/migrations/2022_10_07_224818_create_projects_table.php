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
            $table->tinyInteger('seeking');
            $table->tinyInteger('reader_type')->nullable();
            $table->tinyInteger('feedback_type')->nullable();
            $table->string('genre')->nullable();
            $table->string('word_count')->nullable();
            $table->text('similar_works')->nullable();
            $table->text('preview')->nullable();
            $table->text('content_notices')->nullable();
            $table->text('query_letter')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('unlisted_at')->nullable();
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
