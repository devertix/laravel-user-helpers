<?php

namespace Devertix\LaravelUserHelpers\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line("\nCreate user");

        // this is for programatically using this command
        $email = $this->argument('email');
        $name = $email;
        if (!$email) {
            $email = $this->askEmail();
            $name = $this->askName();
        }
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(mt_rand(10000, 1000000)),
        ]);

        if ($user) {
            $this->info('User ' . $user->name . ' created (' . $user->id . ').');
        }

        return 0;
    }

    private function askName()
    {
        $name = null;

        do {
            $name = $this->ask("User's name");

            $nameValidator = Validator::make([
                'name' => $name,
            ], [
                'name' => 'required|string|max:50',
            ]);

            $this->validationErrors($nameValidator);
        } while ($nameValidator->fails());

        return $name;
    }

    private function askEmail()
    {
        $email = null;

        do {
            $email = $this->ask("Email address");

            $emailValidator = Validator::make([
                'email' => $email,
            ], [
                'email' => 'required|string|email|unique:users|max:255',
            ]);

            $this->validationErrors($emailValidator);
        } while ($emailValidator->fails());

        return $email;
    }

    private function validationErrors(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $errors) {
                foreach ($errors as $error) {
                    $this->error($error);
                }
            }
        }
    }
}
