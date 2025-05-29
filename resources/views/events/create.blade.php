@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Event</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input value="{{ old('title') }}" type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input value="{{ old('location') }}" type="text" name="location" id="location" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input value="{{ old('date') }}" type="date" name="date" id="date" class="form-control" required min="{{ date('Y-m-d') }}">
            </div>

            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Geri Dön</a>
        </form>
    </div>
@endsection
