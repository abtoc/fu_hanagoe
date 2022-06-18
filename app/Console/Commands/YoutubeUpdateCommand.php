<?php

namespace App\Console\Commands;

use App\Channel;
use App\Option;
use App\Repository\YoutubeRepositoryInterface;
use App\Services\YoutubeService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class YoutubeUpdateCommand extends Command
{
    private YoutubeRepositoryInterface $repository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:youtube';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Youtube Transaction Count Updating';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(YoutubeRepositoryInterface $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = new YoutubeService($this->repository);

        $number_next = (int)Option::get('YOUTUBE_NEXT');
        $number_max  = Channel::max('number');
        $read_count  = (int)config('youtube.count');

        $channels = Channel::where('number', '>', $number_next)
                    ->orderBy('number', 'asc')
                    ->take($read_count)->get();
        try {
            DB::beginTransaction();
            foreach($channels as $channel){
                $service->update($channel->id);
                if($channel->number === $number_max){
                    Option::set('YOUTUBE_NEXT', 0);
                } else {
                    Option::set('YOUTUBE_NEXT', $channel->number);
                }
            }
            DB::commit();
        } catch(Throwable $e){
            DB::rollback();
            throw $e;
        }
    }
}
