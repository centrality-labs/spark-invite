<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravel\Spark\Spark;

use ZiNETHQ\SparkInvite\Models\Invitation;

class CreateInvitationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('invitation_id');
            $table->unsignedInteger('audit_team_id')->nullable()->default(null);
            $table->unsignedInteger('audit_user_id')->nullable()->default(null);
            $table->enum('state', Invitation::STATUS)->default(Invitation::STATUS_PENDING);
            $table->string('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('state');
            $table->foreign('invitation_id')->references('id')->on('user_invitations')->onDelete('cascade');
            $table->foreign('audit_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('audit_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invitation_status');
    }
}
