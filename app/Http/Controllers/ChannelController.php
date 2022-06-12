<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index()
    {
    }
    public function show(Channel $channel)
    {
        $transactions = $channel->transactions()->orderBy('date', 'asc')->limit(30)->get();
        $thumbnail = $channel->thumbnails()->where('type', 'default')->first();
        return view('channel.show', compact('channel', 'transactions', 'thumbnail'));
    }
}
