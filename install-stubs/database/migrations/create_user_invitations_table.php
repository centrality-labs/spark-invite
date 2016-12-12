<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravel\Spark\Spark;

use ZiNETHQ\SparkInvite\Models\Invitation;

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
            $table->integer('invitee_id')->nullable()->unsigned();
            $table->integer('referral_team_id')->unsigned();
            $table->integer('referral_user_id')->nullable()->unsigned();
            $table->enum('status', Invitation::STATUS)->default(Invitation::STATUS_PENDING);
            $table->string('token', 40)->nullable();
            $table->string('old_password', 60)->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->unique('token');
            $table->foreign('invitee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('referral_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('referral_user_id')->references('id')->on('users')->onDelete('cascade');
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
