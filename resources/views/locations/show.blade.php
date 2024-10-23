@extends('layouts.app')

@section('title', 'Konum Bilgileri')

@section('css')
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')

    <div class="info-panel">
        <h2>Konum Bilgileri</h2>
        <div class="form-group">
            <label for="name">Konum Adı:</label>
            <input type="text" class="form-control" id="name" value="{{ $location->name }}" readonly />
        </div>
        <div class="form-group">
            <label for="latitude">Enlem:</label>
            <input type="number" class="form-control" id="latitude" value="{{ $location->latitude }}" readonly />
        </div>
        <div class="form-group">
            <label for="longitude">Boylam:</label>
            <input type="number" class="form-control" id="longitude" value="{{ $location->longitude }}" readonly />
        </div>
        <div class="form-group">
            <label for="color">Marker Rengi (Hex Kodu):</label>
            <div style="display: flex; align-items: center;">
                <div style="width: 30px; height: 30px; background-color: {{ $location->hex_color }}; border: 1px solid #ccc;"></div>
                <span class="ms-2">{{ $location->hex_color }}</span>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-primary">Düzenle</a>
        </div>
        <div class="mt-3">
            <a href="{{ route('locations.index') }}" class="btn btn-secondary">Konum Listesi</a>
        </div>
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
        })

        L.marker([locationData.latitude, locationData.longitude], {icon: customIcon }).addTo(map)
            .bindPopup(locationData.name)
            .openPopup();
        
    </script>

@endsection