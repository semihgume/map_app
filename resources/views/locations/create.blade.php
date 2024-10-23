@extends('layouts.app')

@section('title', 'Konum Ekle')

@section('content')

    <div class="container mt-5" style="max-width:500px;">
        <h2>Yeni Konum Ekle</h2>
        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Konum Adı:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="latitude">Enlem:</label>
                <input type="number" class="form-control" id="latitude" name="latitude" step="0.0000001" required>
            </div>
            <div class="form-group">
                <label for="longitude">Boylam:</label>
                <input type="number" class="form-control" id="longitude" name="longitude" step="0.0000001" required>
            </div>
            <div class="form-group">
                <label for="hex_color">Marker Rengi:</label>
                <input type="color" class="form-control" id="hex_color" name="hex_color" pattern="#[0-9a-fA-F]{6}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Ekle</button>
        </form>
    </div>

@endsection