<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Repository\YoutubeRepositoryInterface;
use App\Services\YoutubeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ChannelController extends Controller
{
    private $repository;

    public function __construct(YoutubeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        if(Auth::check()){
            $channels = Auth::user()->channels()->orderBy('created_at', 'asc')->get();
        } else {
            $channels = Channel::orderBy('created_at', 'asc')->get();
        }
        return view("channel.index", compact('channels'));
    }
    public function show(Channel $channel)
    {
        $before30 = Carbon::today()->subDay(30);
        $transactions = $channel->transactions()->where('date','>=', $before30)->orderBy('date', 'asc')->limit(30)->get();
        $thumbnail = $channel->thumbnails()->where('type', 'default')->first();
        return view('channel.show', compact('channel', 'transactions', 'thumbnail'));
    }
    public function create(Request $request)
    {
        $channel_id = $request->query('channel_id', null);
        return view('channel.create', compact('channel_id'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'channel_id' => 'required',
        ]);

        $result = $this->repository->fetch($request->channel_id);
        if(count($result) > 0){
            try {
                DB::beginTransaction();

                $service = new YoutubeService($this->repository);
                $service->update($request->channel_id);

                if(is_null(Auth::user()->channels()->where('channel_id', $request->channel_id)->first())){
                    Auth::user()->channels()->attach($request->channel_id);
                }

                DB::commit();
            } catch(Throwable $e){
                DB::rollBack();
                dd($e);
            }
            return redirect()->route('channel.show', ['channel' => $request->channel_id]);
        }

        $result = $this->repository->search($request->channel_id);
        if(count($result) > 0){
            return redirect()->route('channel.confirm')->with(compact('result'));
        }

        return view('channel.create')->with('channel_id', '指定したチャンネルIDが存在しません');
    }
    public function confirm()
    {
        return view('channel.confirm');
    }
    public function destroy(Channel $channel)
    {
        Auth::user()->channels()->detach($channel->id);
        return redirect()->route('channel.index');        
    }
}
