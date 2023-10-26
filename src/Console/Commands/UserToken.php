<?php

namespace Devertix\LaravelUserHelpers\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class UserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:token {user_email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a valid user token for jwt auth.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userEmail = $this->argument('user_email');
        $user = User::whereEmail($userEmail)->firstOrFail();
        $this->info(sprintf('User ID: %d', $user->id));
        $this->info(sprintf('User email: %s', $user->email));

        $token = Auth::guard()->login($user);
        $this->info("Token:");
        $this->line($token);
        $this->line('');
        return 0;
    }
}
