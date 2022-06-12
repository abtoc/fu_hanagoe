<?php

return [
    'channels' => 'https://www.googleapis.com/youtube/v3/channels',
    'search' => 'https://www.googleapis.com/youtube/v3/search',
    'key' => env('YOUTUBE_KEY'),
    'count' => env('YOUTUBE_COUNT', 100),
];
