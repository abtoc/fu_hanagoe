@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">チャンネル一覧</div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tbody>
                                @foreach($channels as $channel)
                                    <tr>
                                        <td>
                                            <div class="channel-list">
                                                <div class="channel-image picture"><img src="{{ $channel->thumbnails()->where('type','default')->first()->url }}" alt="{{ $channel->title }}"></div>
                                                <div class="channel-right">
                                                    <div class="channel-title">
                                                        <a href="{{ route('channel.show', ['channel' => $channel->id]) }}">
                                                            {{ $channel->title }}
                                                        </a>
                                                    </div>
                                                    <div class="channel-text">
                                                        {{ \Carbon\Carbon::parse($channel->published_at)->format('Y/m/d') }}に登録<br>
                                                        登録者数 {{ number_format($channel->transactions()->orderBy('date', 'desc')->limit(1)->first()->subscriber_count) }} 人
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection