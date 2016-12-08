<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_invitations', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('invitee_id')->nullable()->unsigned()->index();
            $table->foreign('invitee_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('inviter_team_id')->unsigned()->index();
            $table->foreign('inviter_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->integer('inviter_user_id')->nullable()->unsigned()->index();
            $table->foreign('inviter_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('token', 40)->unique();
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
        Schema::drop('user_invitations');
    }
}
