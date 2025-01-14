<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DataChangedNotification;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ParseUserUrl implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        Log::notice("11111 parsing URL 111111");

        $client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);

        $url = $this->user->link;

        try {
            $response = $client->get($url);
            $html = (string)$response->getBody();

            $crawler = new Crawler($html);
            $newData = $crawler->filter('.css-90xrc0')->each(function (Crawler $node) {
                return $node->text();
            });

            $newDataJson = json_encode($newData);
            $savedData = $this->user->parsedata;

            if (!$savedData || $savedData !== $newDataJson) {
                $this->user->update([
                    'parsedata' => $newDataJson,
                ]);
            }
        } catch (\Exception $e) {
            Log::error("Error parsing URL ({$url}): " . $e->getMessage());
        }
    }
}
