@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">チャンネル登録</div>
                    <div class="card-body">
                        <form action="{{ route('channel.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">チャンネルID:</label>
                                <input id="channel_id" type="text" class="form-control @error('name') is-invalid @enderror" name="channel_id" value="{{ old('channel_id', $channel_id) }}" required>
                                @error('channel_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">チャンネルを登録する</button>
                                </div>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection