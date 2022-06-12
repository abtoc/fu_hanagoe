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
                                チャンネル登録者数 {{ $transactions->last()->subscriber_count }}人
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="chart_subscriber"></canvas>
                        <canvas id="chart_subscriber_daily"></canvas>
                        <canvas id="chart_view"></canvas>
                        <canvas id="chart_view_daily"></canvas>
                        <table class="table table-striped">
                           <thead>
                               <tr>
                                   <th class="text-center" colspan="2">日付</th>
                                   <th class="text-center" colspan="2">チャンネル登録者数</th>
                                   <th class="text-center" colspan="2">動画再生数</th>
                                   <th class="text-center" colspan="2">動画本数</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach($transactions as $transaction)
                                    <tr>
                                        <td class="text-right">{{ $transaction->date }}</td>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @php
        $labels = array();
        $subscribers = array();
        $subscribers_daily = array();
        $views = array();
        $views_daily = array();
        foreach($transactions as $transaction){
            array_push($labels, $transaction->date);
            array_push($subscribers, $transaction->subscriber_count);
            array_push($subscribers_daily, $transaction->subscriber_count_daily);
            array_push($views, $transaction->view_count);
            array_push($views_daily, $transaction->view_count_daily);
        }
    @endphp   
    <script>
        function drawChart(id,title,labels, data)
        {
            console.log(labels);
            console.log(data);
            var ctx = document.getElementById(id).getContext('2d');

            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        fill: false
                    }]
                },
                options: {
                    scales: {
                        yAxes: [
                            { ticks: { min: 0}}
                        ]
                    }
                }
            });
        }
        window.onload = function(){
            drawChart('chart_subscriber', 'チャンネル登録者数累計', {!! json_encode($labels) !!}, {!! json_encode($subscribers) !!}); 
            drawChart('chart_subscriber_daily', 'チャンネル登録者数', {!! json_encode($labels) !!}, {!! json_encode($subscribers_daily) !!}); 
            drawChart('chart_view', '再生回数累計', {!! json_encode($labels) !!}, {!! json_encode($views) !!}); 
            drawChart('chart_view_daily', '再生回数', {!! json_encode($labels) !!}, {!! json_encode($views_daily) !!}); 
        }
    </script>
@endsection
