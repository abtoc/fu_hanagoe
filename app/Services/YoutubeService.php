<?php

namespace App\Services;

use App\Channel;
use App\Repository\YoutubeRepositoryInterface;
use Carbon\Carbon;

class YoutubeService
{
    private YoutubeRepositoryInterface $repository;

    public function __construct(YoutubeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function update(String $id)
    {
        $result = $this->repository->fetch($id);

        if($result){      
            $today = Carbon::today();

            $id = $result['id'];
            unset($result['id']);

            $channel = Channel::updateOrCreate(['id' => $id], $result);
            $transaction = $channel->transactions()->updateOrCreate(['date' => $today], $result);
            foreach ($result['thumbnails'] as $thumbnail){
                $channel->thumbnails()->updateOrCreate(['type'=> $thumbnail['type']], $thumbnail);
            }
        }
    }
}