<?php

namespace App\Repository;

use Carbon\Carbon;
use GuzzleHttp\Client;

class YoutubeRepository implements YoutubeRepositoryInterface
{
    public function search(String $q)
    {
        $client = new Client();

        $q = urlencode($q);
        $response = $client->request(
            'GET',
            config('youtube.search').'?type=channel&part=id,snippet&key='.config('youtube.key').'&q='.$q
        );

        $json = $response->getBody();
        $json = json_decode($json);

        $result = array();
        foreach($json->items as $item){
            array_push($result, [
                'channel_id' => $item->snippet->channelId,
                'title' => $item->snippet->title,
                'publish_at' => Carbon::parse($item->snippet->publishTime),
                'thumbnails' => [
                    'default' => $item->snippet->thumbnails->default->url,
                    'medium'  => $item->snippet->thumbnails->medium->url,
                    'high'    => $item->snippet->thumbnails->high->url,
                ],
            ]);
        }

        return $result;
    }
    public function fetch(String $id): array
    {
        $client = new Client();

        $response = $client->request(
            'GET',
            config('youtube.channels').'?part=snippet,statistics&key='.config('youtube.key').'&id='.$id
        );

        $json = $response->getBody();
        $json = json_decode($json);

        if(property_exists($json, 'items')){
            return [
                'id' => $json->items[0]->id,
                'title' => $json->items[0]->snippet->title,
                'description' => $json->items[0]->snippet->description,
                'country' => property_exists($json->items[0]->snippet, 'country') ? $json->items[0]->snippet->country : null,
                'published_at' => Carbon::parse($json->items[0]->snippet->publishedAt),
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