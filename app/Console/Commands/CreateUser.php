<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\InputOption;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates an admin user';

    protected function configure()
    {
        $this->addOption('email', null, InputOption::VALUE_REQUIRED);
        $this->addOption('password', null, InputOption::VALUE_REQUIRED);
        $this->addOption('name', null, InputOption::VALUE_REQUIRED);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User();
        $user->name = $this->option('name');
        $user->email = $this->option('email');
        $user->password = Hash::make($this->option('password'));
        $user->role = 'admin';

        $user->save();

        return Command::SUCCESS;
    }
}
