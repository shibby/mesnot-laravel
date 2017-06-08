<?php

namespace Shibby\Mesnot\Commands;

use Illuminate\Console\Command;
use Shibby\Mesnot\MesnotClient;

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
        /** @var MesnotClient $mesnotClient */
        $mesnotClient = app(MesnotClient::class);

        $userClass = config('mesnot.user.class');

        $users = $userClass::all();
        foreach ($users as $user) {
            $mesnotClient->updateClient($user);
        }
    }
}
