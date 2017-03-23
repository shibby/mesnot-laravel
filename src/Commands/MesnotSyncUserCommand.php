<?php

namespace Shibby\Mesnot\Commands;

use App\Model\User;
use Illuminate\Console\Command;
use Shibby\Mesnot\MessageNotify;

class MesnotSyncUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mesnot:sync:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs users with mesnot service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var MessageNotify $messageNotify */
        $messageNotify = app(MessageNotify::class);

        $users = User::all();
        foreach ($users as $user) {
            $messageNotify->updateClient($user);
        }
    }
}
