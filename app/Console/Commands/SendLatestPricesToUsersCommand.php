<?php

namespace App\Console\Commands;

use App\Jobs\SendPricesEmailJob;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendLatestPricesToUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-latest-prices-to-users-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends the latest currency prices to all subscribed users via email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $navasan_api_key = env('NAVASAN_API_KEY');

        $response = Http::get("http://api.navasan.tech/latest/", [
            'api_key' => $navasan_api_key,
        ]);

        if ($response->ok()) {
            $prices_data = $response->json();
        } else {
            throw new Exception("Failed to retrieve prices list.");
        }

        $users = User::all();

        foreach ($users as $user) {
            SendPricesEmailJob::dispatch($user, $prices_data);
            echo $user->name;
        }
    }
}
