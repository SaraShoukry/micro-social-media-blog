<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('follower_id');
            $table->foreign('follower_id')->references('id')->on('users');
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

        Schema::table('followers', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // drop the foreign key.
            $table->dropColumn('user_id'); // drop the column
            $table->dropForeign(['follower_id']); // drop the foreign key.
            $table->dropColumn('follower_id'); // drop the column
        });
        Schema::dropIfExists('followers');
    }
}
