<?php

namespace App\Services;

use App\Notifications\DataChangedNotification;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ParseService
{
    protected $client;
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]
        ]);
    }
    public function processUsers()
    {
        $users = User::all();
        $processedUrls = [];

        foreach ($users as $user) {
            $url = $user->link;
            $email = $user->email;

            if (array_key_exists($url, $processedUrls)) {
                $user->update([
                    'parsedata' => $processedUrls[$url]
                ]);
                continue;
            }
            try {
                $response = $this->client->get($url);
                $html = (string)$response->getBody();

                $crawler = new Crawler($html);
                $newData = $crawler->filter('.css-90xrc0')->each(function (Crawler $node) {
                    return $node->text();
                });

                $newDataJson = json_encode($newData);
                $savedData = $user->parsedata;

                if (!$savedData || $savedData !== $newDataJson) {
                    $parsetime = Carbon::now();
                    Notification::route('mail', $email)
                        ->notify(new DataChangedNotification($newData));
                    $user->update([
                        'parsedata' => $newDataJson,
                        'parsetime' => $parsetime
                    ]);

                    $processedUrls[$url] = $newDataJson;
                }
            } catch (\Exception $e) {
                Log::error("Error parsing URL ({$url}): " . $e->getMessage());
            }
        }
    }
}
