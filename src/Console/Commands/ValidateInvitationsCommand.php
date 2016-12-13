<?php

namespace ZiNETHQ\SparkInvite\Console\Commands;

use Illuminate\Console\Command;
use ZiNETHQ\SparkInvite\Models\Invitation;
use ZiNETHQ\SparkInvite\Models\InvitationStatus;

class ValidateInvitationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sparkinvite:validate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate existing pending invitations for expiry or success';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $invitations = Invitation::whereHas('status', function ($query) {
             $query->where('state', Invitation::STATUS_PENDING);
        })->get();

        foreach ($invitations as $invitation) {
            $invitation->validate();
        }
    }
}
