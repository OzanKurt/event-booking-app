@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $exception->getMessage() }}</h1>

        <a href="{{ route('events.index') }}" class="btn btn-secondary mt-3">Etkinliklere geri dön</a>
    </div>

@endsection
