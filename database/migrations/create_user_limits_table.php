<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLImitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_limits', function (Blueprint $table) {
            $table->id();
            $table->string('user_type')->nullable();
            $table->bigInteger('user_id');
            $table->foreignId('category_id');
            $table->foreign('category_id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('limit_type');
            $table->string('amount');
            $table->string('currency', 3);
            $table->timestamps();
            $table->unique(['user_type', 'user_id', 'category_id', 'limit_type'], 'user_category_limit_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_limits');
    }
}
