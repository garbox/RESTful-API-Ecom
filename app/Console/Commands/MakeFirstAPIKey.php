<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\ApiToken;
use App\Models\Admin;

class MakeFirstAPIKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin-api-token';
    protected $description = 'Create applications admin API token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $existingToken = ApiToken::first(); // Get the first token record from the database
        
        if ($existingToken) {
            $this->line('');
            $this->line('API token already exists:');
            $this->info($existingToken->api_token);
            $this->line(""); 
        } 
        else {
            $name = $this->ask('What is going to use this key');
            $token = [
                'app_name' => $name,
                'api_token' => Str::random(34), // Generate a new API token
                'admin_token' => true,
            ];
            $apiToken = ApiToken::create($token);
            $this->line('Application token created: ');
            $this->info($apiToken->api_token);
            $this->line(""); 

            $admin = Admin::factory()->make();

            $this->line('Admin username: ');
            $this->info($admin->email);
            $this->line('Admin password: ');
            $this->info($admin->raw_password);
            $this->line('Admin token: ');
            $this->info($admin->api_token);
            $this->line(""); 
            $this->info('Dont lose this info for its the last time you will see it.');
            unset($admin->raw_password);
            $admin->save();
        }


    

    }
}
