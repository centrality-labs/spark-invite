<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravel\Spark\Spark;

use CentralityLabs\SparkInvite\Models\Invitation;

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
            $table->increments('id');
            $table->unsignedInteger('invitee_id')->nullable();
            $table->unsignedInteger('team_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->uuid('token')->nullable();
            $table->string('old_password', 60)->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('token');
            $table->foreign('invitee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
