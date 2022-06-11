<?php

namespace App\Repository;

use GuzzleHttp\Client;

class YoutubeRepository implements YoutubeRepositoryInterface
{
    public function fetch(String $id): array
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            config('youtube.ap').'?part=snippet,statistics&key='.config('youtube.key').'&id='.$id
        );

        $json = $response->getBody();
        $json = json_decode($json);

        if(property_exists($json, 'items')){
            return [
                'id' => $json->items[0]->id,
                'title' => $json->items[0]->snippet->title,
                'description' => $json->items[0]->snippet->description,
                'view_count' => $json->items[0]->statistics->viewCount,
                'subscriber_count' => $json->items[0]->statistics->subscriberCount,
                'video_count' => $json->items[0]->statistics->videoCount,
                'thumbnails' => [
                    [
                        'type' => 'default',
                        'url' => $json->items[0]->snippet->thumbnails->default->url,
                        'width' =>  $json->items[0]->snippet->thumbnails->default->width,
                        'height' =>  $json->items[0]->snippet->thumbnails->default->height,
                    ],
                    [
                        'type' => 'medium',
                        'url' => $json->items[0]->snippet->thumbnails->medium->url,
                        'width' =>  $json->items[0]->snippet->thumbnails->medium->width,
                        'height' =>  $json->items[0]->snippet->thumbnails->medium->height,
                    ],
                    [
                        'type' => 'high',
                        'url' => $json->items[0]->snippet->thumbnails->high->url,
                        'width' =>  $json->items[0]->snippet->thumbnails->high->width,
                        'height' =>  $json->items[0]->snippet->thumbnails->high->height,
                    ],
                ],
            ];
        }
        return [];
    }
}