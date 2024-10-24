@extends('layouts.app')

@section('title', 'Düzenle')

@section('css')
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')

    <div class="info-panel">
        <h2>Konum Bilgilerini Düzenle</h2>
        <form action="{{ route('locations.update', $location->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Konum Adı:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $location->name }}" required />
            </div>
            <div class="form-group">
                <label for="latitude">Enlem:</label>
                <input type="number" class="form-control" id="latitude" name="latitude" step="0.0000001" value="{{ $location->latitude }}" required />
            </div>
            <div class="form-group">
                <label for="longitude">Boylam:</label>
                <input type="number" class="form-control" id="longitude" name="longitude" step="0.0000001" value="{{ $location->longitude }}" required />
            </div>
            <div class="form-group">
                <label for="color">Marker Rengi:</label>
                <input type="color" class="form-control" id="color" name="hex_color" value="{{ $location->hex_color }}" required />
            </div>

            <button class="btn btn-primary" type="submit">Kaydet</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger m-3" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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