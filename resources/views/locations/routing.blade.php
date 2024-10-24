@extends('layouts.app')

@section('title', 'Rota Oluştur')

@section('css')
<link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@section('content')

    <div class="info-panel">
        <h2>Rotaları Oluştur</h2>
        <div class="form-group">
            <label for="latitude">Enlem:</label>
            <input type="number" class="form-control" id="latitude" name="latitude" step="0.0000001" required />
        </div>
        <div class="form-group">
            <label for="longitude">Boylam:</label>
            <input type="number" class="form-control" id="longitude" name="longitude" step="0.0000001" required />
        </div>
        <button class="btn btn-primary" id="calculateBtn">Rotaları Çiz</button>
        <div class="mt-3">
            <a href="{{ route('locations.index') }}" class="btn btn-secondary">Konum Listesi</a>
        </div>
    </div>

    <div id="map"></div>

@endsection

@section('script')

    <script src="{{ asset('js/leaflet.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script>

        const locations = @json($locations);
        const map = L.map('map').setView([40, 29], 3);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);


        $('#calculateBtn').on('click', function() {

            const latitude = $('#latitude').val();
            const longitude = $('#longitude').val();

            if(!latitude || !longitude) {
                alert("Enlem ve Boylam alanları doldurulmalıdır.");
                event.preventDefault();
                return;
            }

            if (latitude < -90 || latitude > 90) {
                alert('Enlem değeri -90 ile 90 arasında olmalıdır.');
                event.preventDefault();
                return;
            }

            if (longitude < -180 || longitude > 180) {
                alert('Boylam değeri -180 ile 180 arasında olmalıdır.');
                event.preventDefault();
                return;
            }
            
            let errorFlag = false;

            L.marker([latitude, longitude])
                .addTo(map)
                .bindPopup("Hedef Konum")
                .openPopup();

            locations.forEach(location => {

                const url = `https://router.project-osrm.org/route/v1/driving/${longitude},${latitude};${location.longitude},${location.latitude}?overview=full&geometries=geojson`;
                
                $.ajax({
                    url: url,
                    method: "GET",
                    dataType: "json",
                    success: function(routeData) {
                        console.log(routeData);
                        
                        L.geoJSON(routeData.routes[0].geometry, {
                            style: { color: location.hex_color }
                        }).addTo(map);

                        const customIcon = L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="width: 20px; height: 20px; background-color: ${location.hex_color}; border-radius: 50%;"></div>`
                        });

                        L.marker([location.latitude, location.longitude], { icon: customIcon })
                            .addTo(map)
                            .bindPopup(location.name)
                            .openPopup();

                    },
                    error: function(xhr, status, error) {
                        if(!errorFlag) {
                            alert(xhr.responseJSON.message);
                            errorFlag = true;
                        }
                    }
                });
            });           
        });

    </script>

@endsection