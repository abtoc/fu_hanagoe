<?php

namespace App\Services;

use App\Channel;
use App\Repository\YoutubeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

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
            try {
                DB::beginTransaction();

                $today = Carbon::today();

                $id = $result['id'];
                unset($result['id']);

                $channel = Channel::updateOrCreate(['id' => $id], $result);
                $transaction = $channel->transactions()->updateOrCreate(['date' => $today], $result);
                foreach ($result['thumbnails'] as $thumbnail){
                    $channel->thumbnails()->updateOrCreate(['type'=> $thumbnail['type']], $thumbnail);
                }

                DB::commit();
            } catch(Throwable $e) {
                DB::rollback();
            }
        }
    }
}