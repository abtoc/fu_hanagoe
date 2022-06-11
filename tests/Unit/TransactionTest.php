<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
    }

    public function test_トランザクション件数のテスト()
    {
        $today = Carbon::today();
        $yesterday1 = $today->copy()->subDay();
        $yesterday2 = $yesterday1->copy()->subDay();

        $channel = factory(\App\Channel::class)->create();
        $channel = factory(\App\Channel::class)->create();
        $this->assertEquals(\App\Channel::all()->count(), 2);

        $transaction = $channel->transactions()->updateOrCreate(
            ['date' => $yesterday2],
            ['view_count' => 50, 'subscriber_count' => 5, 'video_count' => 1]
        );
        $this->assertEquals($transaction->view_count, 50);
        $this->assertEquals($transaction->view_count_daily, 0);
        $this->assertEquals($transaction->subscriber_count, 5);
        $this->assertEquals($transaction->subscriber_count_daily, 0);
        $this->assertEquals($transaction->video_count, 1);
        $this->assertEquals($transaction->video_count_daily, 0);
        $transaction = $channel->transactions()->updateOrCreate(
            ['date' => $yesterday2],
            ['view_count' => 100, 'subscriber_count' => 10, 'video_count' => 2]
        );
        $this->assertEquals($transaction->view_count, 100);
        $this->assertEquals($transaction->view_count_daily, 0);
        $this->assertEquals($transaction->subscriber_count, 10);
        $this->assertEquals($transaction->subscriber_count_daily, 0);
        $this->assertEquals($transaction->video_count, 2);
        $this->assertEquals($transaction->video_count_daily, 0);
        $transaction = $channel->transactions()->updateOrCreate(
            ['date' => $yesterday1],
            ['view_count' => 150, 'subscriber_count' => 15, 'video_count' => 4]
        );
        $this->assertEquals($transaction->view_count, 150);
        $this->assertEquals($transaction->view_count_daily, 50);
        $this->assertEquals($transaction->subscriber_count, 15);
        $this->assertEquals($transaction->subscriber_count_daily, 5);
        $this->assertEquals($transaction->video_count, 4);
        $this->assertEquals($transaction->video_count_daily, 2);
        $transaction = $channel->transactions()->updateOrCreate(
            ['date' => $yesterday1],
            ['view_count' => 200, 'subscriber_count' => 20, 'video_count' => 8]
        );
        $this->assertEquals($transaction->view_count, 200);
        $this->assertEquals($transaction->view_count_daily, 100);
        $this->assertEquals($transaction->subscriber_count, 20);
        $this->assertEquals($transaction->subscriber_count_daily, 10);
        $this->assertEquals($transaction->video_count, 8);
        $this->assertEquals($transaction->video_count_daily, 6);
        $transaction = $channel->transactions()->updateOrCreate(
            ['date' => $today],
            ['view_count' => 400, 'subscriber_count' => 40, 'video_count' => 16]
        );
        $this->assertEquals($transaction->view_count, 400);
        $this->assertEquals($transaction->view_count_daily, 200);
        $this->assertEquals($transaction->subscriber_count, 40);
        $this->assertEquals($transaction->subscriber_count_daily, 20);
        $this->assertEquals($transaction->video_count, 16);
        $this->assertEquals($transaction->video_count_daily, 8);

        $transactions = $channel->transactions();
        $this->assertEquals($transactions->count(), 3);
    }
}
