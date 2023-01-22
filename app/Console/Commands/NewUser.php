<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class NewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user in database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
            'is_admin' => 1,
        ]);
        if ($user) {
            return $this->info('user created successfully');
        }
        return $this->error('error with creating user');

    }
}