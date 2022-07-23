@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header channel-header">
                        <div class="channel-image"> <img src="{{ $thumbnail->url }}" alt="{{ $channel->title }}"></div>
                        <div class="channel-right">
                            <div class="channel-title">{{ $channel->title }}</div>
                            <div class="channel-text">
                                {{ \Carbon\Carbon::parse($channel->published_at)->format('Y/m/d') }}に登録<br>
                                チャンネル登録者数 {{ number_format($transactions->last()->subscriber_count) }}人
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <h5>●チャンネル登録者数推移</h5>
                                <canvas id="chart_subscriber"></canvas>
                                <h5>●チャンネル登録者数</h5>
                                <canvas id="chart_subscriber_daily"></canvas>
                                <h5>●再生回数推移</h5>
                                <canvas id="chart_view"></canvas>
                                <h5>●再生回数</h5>
                                <canvas id="chart_view_daily"></canvas>
                                <h5>●動画あたりの再生数</h5>
                                <canvas id="chart_view_video"></canvas>
                                <h5 style="display: inline;">●DATA</h5>({{ $transactions->last()->updated_at }}更新)
                                <table class="table table-striped table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="2">日付</th>
                                        <th class="text-center" colspan="2">登録者数</th>
                                        <th class="text-center" colspan="2">再生数</th>
                                        <th class="text-center" colspan="2">動画本数</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                            <tr>
                                                <td class="text-right">{{ \Carbon\Carbon::parse($transaction->date)->format('y/m/d') }}</td>
                                                <td class="text-right">{{ \Carbon\Carbon::parse($transaction->date)->isoFormat('ddd') }}</td>
                                                <td class="text-right">{{ number_format($transaction->subscriber_count) }}</td>
                                                <td class="text-right">{{ number_format($transaction->subscriber_count_daily) }}</td>
                                                <td class="text-right">{{ number_format($transaction->view_count) }}</td>
                                                <td class="text-right">{{ number_format($transaction->view_count_daily) }}</td>
                                                <td class="text-right">{{ number_format($transaction->video_count) }}</td>
                                                <td class="text-right">{{ number_format($transaction->video_count_daily) }}</td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            @guest
                                <div class="btn-group" role="group"  aria-label="Button Group">
                                    <a class="btn btn-outline-primary" href="{{ 'https://www.youtube.com/channel/'.$channel->id.'/featured' }}" target="blank">チャンネルへ</a>
                                    <a href="{{ route('channel.create', ['channel_id' => $channel->id]) }}" class="btn btn-outline-primary">チャンネル登録をする</a>
                                </div>
                            @else
                                <form action="{{ route('channel.destroy', ['channel' => $channel->id ]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group" role="group"  aria-label="Button Group">
                                        <a class="btn btn-outline-primary" href="{{ 'https://www.youtube.com/channel/'.$channel->id.'/featured' }}" target="blank">チャンネルへ</a>
                                        <input type="submit" class="btn btn-outline-primary" value="チャンネル登録を解除する">
                                    </div>
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @php
        $last = count($transactions) - 1;
        $labels = array();
        $subscribers = array();
        $subscribers_daily = array();
        $views = array();
        $views_daily = array();
        $views_videos = array();
        foreach($transactions as $index => $transaction){
            array_push($labels, \Carbon\Carbon::parse($transaction->date)->format('m/d'));
            array_push($subscribers, $transaction->subscriber_count);
            array_push($subscribers_daily, $transaction->subscriber_count_daily);
            array_push($views, $transaction->view_count);
            if(($index !== $last)  or ($transaction->view_count_daily > 0)){
                array_push($views_daily, $transaction->view_count_daily);
                if($transaction->video_count === 0){
                    array_push($views_videos, 0);
                } else {
                    array_push($views_videos, round($transaction->view_count / $transaction->video_count));
                }
            }
        }
    @endphp   
    <script>
        function drawChart(id,title,labels, data)
        {
            var ctx = document.getElementById(id).getContext('2d');

            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        lineTension: 0,
                        fill: false
                    }]
                },
                options: {
                    legend: {
                        display: false,
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(label, index, labels){
                                    if(label >= 10000){
                                        return label/10000+"万";
                                    }
                                    return label;
                                }
                            }
                        }],
                        xAxes: [{
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }]
                    }
                }
            });
        }
        window.onload = function(){
            drawChart('chart_subscriber', 'チャンネル登録者数累計', {!! json_encode($labels) !!}, {!! json_encode($subscribers) !!}); 
            drawChart('chart_subscriber_daily', 'チャンネル登録者数', {!! json_encode($labels) !!}, {!! json_encode($subscribers_daily) !!}); 
            drawChart('chart_view', '再生回数累計', {!! json_encode($labels) !!}, {!! json_encode($views) !!}); 
            drawChart('chart_view_daily', '再生回数', {!! json_encode($labels) !!}, {!! json_encode($views_daily) !!}); 
            drawChart('chart_view_video', '動画あたりの再生数', {!! json_encode($labels) !!}, {!! json_encode($views_videos) !!})
        }
    </script>
@endsection
