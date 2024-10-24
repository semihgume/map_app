@extends('layouts.app')

@section('title', 'Konumlar')

@section('css')
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')

    <div class="info-panel" style="width: 40%">
        <h2>Konum Listesi</h2>
        <table>
            <thead>
                <tr>
                    <th>Konum Adı</th>
                    <th>Enlem</th>
                    <th>Boylam</th>
                    <th>Renk</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr onclick="showLocation({{ $location->latitude }}, {{ $location->longitude }}, '{{ $location->name }}', '{{ $location->hex_color }}', this)">
                    <td>{{ $location->name }}</td>
                    <td>{{ $location->latitude }}</td>
                    <td>{{ $location->longitude }}</td>
                    <td>
                        <div class="color-box" style="background-color: {{ $location->hex_color }}"></div>
                        {{ $location->hex_color }}
                    </td>
                    <td>
                        <a href="{{ route('locations.show', $location->id) }}" class="btn btn-sm btn-secondary">Detay</a>
                        <a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning">Düzenle</a>
                    </td>  
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            <a href="{{ route('locations.create') }}" class="btn btn-primary">Yeni Konum Ekle</a>
        </div>
        <div class="mt-3">
            <a href="{{ route('locations.routing') }}" class="btn btn-dark">Rota Oluştur</a>
        </div>
    </div>

    <div id="map"></div>

@endsection

@section('script')

    <script src="{{ asset('js/leaflet.js') }}"></script>

    <script>
        
        var map = L.map('map').setView([40,28], 4);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker;
        var selectedRow = null;

        function showLocation(lat, lng, name, color, row) {
            
            if (selectedRow) {
                selectedRow.classList.remove('selected');
            }

            row.classList.add('selected');
            selectedRow = row;

            if (marker) {
                map.removeLayer(marker);
            }

            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="width: 20px; height: 20px; background-color: ${color}; border-radius: 50%;"></div>`
            })

            marker = L.marker([lat, lng], { icon: customIcon }).addTo(map)
                .bindPopup(name)
                .openPopup();

            map.setView([lat, lng], 12);
        }

    </script>

@endsection