<?php

namespace Devertix\LaravelUserHelpers\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Password reset tool');
        $email = $this->ask('Please enter user\'s email', null);

        if (empty($email)) {
            $this->error('Empty e-mail!');
            return 1;
        }

        $user = User::whereEmail($email)->firstOrFail();

        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        $password = $this->askPassword();

        $user->update([
            'password' => Hash::make($password),
        ]);

        $this->info('Success!');
    }

    private function askPassword()
    {
        do {
            $password = $this->secret('Password', false);
        } while (empty($password));
        return $password;
    }
}
