<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\ApiToken;

class MakeFirstAPIKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:first-api-token';
    protected $description = 'Create applications first API token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ask the user for the app name

    
        $existingToken = ApiToken::first(); // Get the first token record from the database
    
        if ($existingToken) {
            $this->line('');
            $this->line('API token already exists:');
            $this->info($existingToken->api_token);
        } else {
            $name = $this->ask('What is going to use this key');
            $token = [
                'app_name' => $name,
                'api_token' => Str::random(34), // Generate a new API token
            ];
    

            $apiToken = ApiToken::create($token);
    
            $this->line('API token created: ');
            $this->info($apiToken->api_token);
        }
    
        $this->line(""); 
    }
}
