    <form id="eventEditForm" method="POST" action="{{ route('events.update', $event->event_id) }}" >
        @csrf
        @method('PUT')
        <input type="hidden" name="lat" id="lat" value="{{ $event->lat }}">
        <input type="hidden" name="long" id="long" value="{{ $event->long }}">
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="title" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $event->title }}" required>
                </div>
                <div class="mb-3">
                    <label for="media_url" class="form-label">Media URL</label>
                    <input type="text" class="form-control" id="media_url" name="media_url" value="{{ $event->media_url }}" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ $event->date }}" required>
                </div>
                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $event->start_time }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $event->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="mode" class="form-label">Mode</label>
                    <select class="form-select" id="mode" name="mode" required>
                        <option value="1" {{ $event->mode ? 'selected' : '' }}>Online</option>
                        <option value="0" {{ !$event->mode ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3" id="onlineFields" style="{{ $event->mode ? 'display: block;' : 'display: none;' }}">
                    <label for="online_url" class="form-label">Online URL</label>
                    <input type="text" class="form-control" id="online_url" name="online_url" value="{{ $event->online_url }}">
                </div>
                <div class="mb-3" id="offlineFields" style="{{ !$event->mode ? 'display: block;' : 'display: none;' }}">
                    <label for="offline_address" class="form-label">Offline Address</label>
                    <input type="text" class="form-control" id="offline_address" name="offline_address" value="{{ $event->offline_address }}" required>
                    <div id="suggestionBox" class="suggestion-box" style="position: absolute; z-index: 1000; background: white; border: 1px solid #ccc;"></div>
                    <button type="button" class="btn btn-secondary mt-2" id="showMapButton">Map</button>
                </div>
                <div id="mapField" style="{{ !$event->mode ? 'display: block;' : 'display: none;' }}">
                    <div id="map" style="height: 300px;"></div>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Update Event</button>
            </div>
            

        </div>

    </form>

{{--     <form method="POST" action="{{ route('events.destroy', $event->event_id) }}" onsubmit="return confirm('Are you sure you want to delete this event?');" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form> --}}


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Leaflet API for map
    var map = L.map('map').setView([{{ $event->lat ?? '51.505' }}, {{ $event->long ?? '-0.09' }}], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    var marker = L.marker([{{ $event->lat ?? '51.505' }}, {{ $event->long ?? '-0.09' }}], { draggable: true }).addTo(map);

    function updateMarker(lat, lng) {
        marker.setLatLng([lat, lng]).update();
        map.setView([lat, lng], 13);
        document.getElementById('lat').value = lat; // Update hidden latitude field
        document.getElementById('long').value = lng; // Update hidden longitude field
        reverseGeocode(lat, lng);
    }

    function reverseGeocode(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('offline_address').value = data.display_name;
            })
            .catch(error => console.error('Error:', error));
    }

    function nominatimSearch(query) {
        fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                displaySuggestions(data);
            });
    }

    function displaySuggestions(suggestions) {
        var suggestionBox = document.getElementById('suggestionBox');
        suggestionBox.innerHTML = '';

        if (suggestions.length === 0) {
            suggestionBox.classList.remove('visible');
            return;
        }

        suggestionBox.classList.add('visible');

        suggestions.forEach(suggestion => {
            var suggestionItem = document.createElement('div');
            suggestionItem.textContent = suggestion.display_name;
            suggestionItem.classList.add('suggestion-item');
            suggestionItem.addEventListener('click', function() {
                document.getElementById('offline_address').value = suggestion.display_name;
                updateMarker(suggestion.lat, suggestion.lon);
                suggestionBox.innerHTML = '';
                suggestionBox.classList.remove('visible');
            });
            suggestionBox.appendChild(suggestionItem);
        });
    }

    document.getElementById('offline_address').addEventListener('input', function() {
        var query = this.value;
        if (query.length >= 3) {
            nominatimSearch(query);
        } else {
            document.getElementById('suggestionBox').classList.remove('visible');
        }
    });

    document.getElementById('mode').addEventListener('change', function() {
        var onlineFields = document.getElementById('onlineFields');
        var offlineFields = document.getElementById('offlineFields');
        var mapField = document.getElementById('mapField');

        if (this.value === "1") {
            document.getElementById('offline_address').value = '';
            document.getElementById('lat').value = ''; // Clear hidden latitude field
            document.getElementById('long').value = ''; // Clear hidden longitude field
            onlineFields.style.display = 'block';
            offlineFields.style.display = 'none';
            mapField.style.display = 'none';
        } else {
            document.getElementById('online_url').value = '';
            onlineFields.style.display = 'none';
            offlineFields.style.display = 'block';
            mapField.style.display = 'block';
        }
    });

    document.getElementById('showMapButton').addEventListener('click', function() {
        var mapField = document.getElementById('mapField');
        if (mapField.style.display === 'none' || mapField.style.display === '') {
            mapField.style.display = 'block';
        } else {
            mapField.style.display = 'none';
        }
    });

    marker.on('dragend', function(e) {
        var latLng = e.target.getLatLng();
        updateMarker(latLng.lat, latLng.lng);
    });
</script>


