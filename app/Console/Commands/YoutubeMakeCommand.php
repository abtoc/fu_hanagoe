<?php

namespace App\Console\Commands;

use App\Repository\YoutubeRepositoryInterface;
use App\Services\YoutubeService;
use Illuminate\Console\Command;

class YoutubeMakeCommand extends Command
{
    private YoutubeRepositoryInterface $repository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:youtube {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $id = $this->argument('id');
        $service = new YoutubeService($this->repository);

        $result = $this->repository->fetch($id);
        if($result){
            $service->update($id);
            $this->info($id.' is created!');
        } else {
            $this->warn($id.' is not created!!');
        }
    }
}
