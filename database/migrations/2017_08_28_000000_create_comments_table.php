<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function ($table) {
            $table->increments('id');
            NestedSet::columns($table);
            $table->unsignedInteger('commentable_id');
            $table->string('commentable_type');
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->text('body');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->index(['commentable_id', 'commentable_type'], 'commentable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
