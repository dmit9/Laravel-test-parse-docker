<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\ParseUserUrl;
use Illuminate\Support\Facades\Log;

class ParsePrice extends Command
{
    protected $signature = 'parse:parsedata';
    protected $description = 'Parse price from Olx';

    public function handle()
    {
        Log::notice("222 parsing URL 222");

        $users = User::all();

        $delay = 0;
        $processedUrls = [];

        foreach ($users as $user) {
            $url = $user->link;
            if (array_key_exists($url, $processedUrls)) {
                $user->update([
                    'parsedata' => $processedUrls[$url]
                ]);
                continue;
            }
            ParseUserUrl::dispatch($user)->delay(now()->addSeconds($delay));
            $delay += 30;
        }

        $this->info('All users added to the queue with delay.');
    }
}
