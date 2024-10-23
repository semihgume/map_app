@extends('layouts.app')

@section('title', 'Düzenle')

@section('css')
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
<style>
    body {
        display: flex;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .info-panel {
        width: 20%;
        padding: 20px;
        background-color: #f9f9f9;
        border-right: 1px solid #ddd;
    }

    #map {
        flex-grow: 1;
        height: 100%;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f0f0f0;
    }

    input[readonly] {
        background-color: #e9ecef;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>
@endsection

@section('content')

    <div class="info-panel">
        <h2>Konum Bilgilerini Düzenle</h2>
        <form action="{{ route('locations.update', $location->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Konum Adı:</label>
                <input type="text" id="name" name="name" value="{{ $location->name }}" required />
            </div>
            <div class="form-group">
                <label for="latitude">Enlem:</label>
                <input type="text" id="latitude" name="latitude" value="{{ $location->latitude }}" required />
            </div>
            <div class="form-group">
                <label for="longitude">Boylam:</label>
                <input type="text" id="longitude" name="longitude" value="{{ $location->longitude }}" required />
            </div>
            <div class="form-group">
                <label for="color">Marker Rengi:</label>
                <input type="color" id="color" name="hex_color" value="{{ $location->hex_color }}" required />
            </div>

            <button type="submit">Kaydet</button>
        </form>
    </div>

    <div id="map"></div>

@endsection

@section('script')

    <script src="{{ asset('js/leaflet.js') }}"></script>

    <script>
        var locationData = @json($location);

        var map = L.map('map').setView([locationData.latitude, locationData.longitude], 6);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="width: 20px; height: 20px; background-color: ${locationData.hex_color}; border-radius: 50%;"></div>`
        });

        L.marker([locationData.latitude, locationData.longitude], {icon: customIcon }).addTo(map)
            .bindPopup(locationData.name)
            .openPopup();
    </script>

@endsection