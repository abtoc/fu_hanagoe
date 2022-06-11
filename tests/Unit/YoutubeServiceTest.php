<?php

namespace Tests\Unit;

use App\Services\YoutubeService;
use App\Repository\YoutubeRepositoryInterface;
use Mockery;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class YoutubeServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /*
    public function test_YouTubeからの情報取得テスト()
    {
        $test_data1 = [
            'id'               => 'XXXXXXXXXXXXXX010',
            'title'            => 'title1',
            'description'      => 'descrpition1',
            'view_count'       => 100,
            'subscriber_count' => 10,
            'video_count'      => 1,
            'thumbnails' => [
                [ 'type' => 'default', 'url' => 'http://hoge.local/010', 'width' => 80, 'height' => 80],
                [ 'type' => 'mideum',  'url' => 'http://hoge.local/012', 'width' => 80, 'height' => 80],
                [ 'type' => 'high',    'url' => 'http://hoge.local/013', 'width' => 80, 'height' => 80],
            ],
        ];

        $mock = Mockery::mock(YoutubeRepository::class)
                ->shouldReceive('fetch')
                ->times(1)
                ->andReturn($test_data1)
                ->getMock();
        
        $this->app->bind(YoutubeRepositoryInterface::class, function() use ($mock) { return $mock; });
        $repository = $this->app->make(YoutubeRepositoryInterface::class);

        $service = new YoutubeService($repository);

        $service->update($test_data1['id']);
    }
    */
}
