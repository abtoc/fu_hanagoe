@extends('layouts.app')

@section('content')
    @php
        $items = session('result');
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">チャンネル選択</div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td><img src="{{ $item['thumbnails']['default'] }}" alt="{{ $item['title'] }}" width="44">
                                        <td class="align-middle text-left">{{ $item['title'] }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('channel.store') }}">
                                                @csrf
                                                <input type="hidden" id="channel_id" name="channel_id" value="{{ $item['channel_id'] }}">
                                                <input type="submit" class="btn btn-primary" value="チャンネルを登録">
                                            </form>
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