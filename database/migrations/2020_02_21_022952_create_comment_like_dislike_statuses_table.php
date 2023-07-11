<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentLikeDislikeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_like_dislike_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('commenter_id');
            $table->integer('user_id');
            $table->string('like_status');
            $table->string('dislike_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_like_dislike_statuses');
    }
}
