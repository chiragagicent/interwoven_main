<form id="eventCreateForm">
    @csrf 
    <div class="row">
        <div class="col-md-6">
            <div class="row mb-4">
                <label for="title" class="col-sm-3 col-form-label">Event Title</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Event Title" required>
                </div>
            </div>
            <div class="row mb-4">
                <label for="media_url" class="col-sm-3 col-form-label">Media URL</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="media_url" name="media_url" placeholder="Enter Media URL" required>
                </div>
            </div>
            <div class="row mb-4">
                <label for="date" class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
            </div>
            <div class="row mb-4">
                <label for="start_time" class="col-sm-3 col-form-label">Start Time</label>
                <div class="col-sm-9">
                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                </div>
            </div>
            <div class="row mb-4">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Event Description" required></textarea>
                </div>
            </div>
            <div class="row mb-4">
                <label for="mode" class="col-sm-3 col-form-label">Mode</label>
                <div class="col-sm-9">
                    <select class="form-select" id="mode" name="mode" required>
                        <option value="1">Online</option>
                        <option value="0">Offline</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row mb-4" id="onlineFields">
                <label for="online_url" class="col-sm-3 col-form-label">Online URL</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="online_url" name="online_url" placeholder="Enter Online URL">
                </div>
            </div>
            <div class="row mb-4" id="offlineFields" style="display: none;">
                    <label for="offline_address" class="col-sm-3 col-form-label">Offline Address</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="offline_address" name="offline_address" placeholder="Enter Offline Address">
                        <div id="suggestionBox" class="suggestion-box"></div> 
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-secondary" id="showMapButton">Map</button>
                    </div>
            </div>

            <!-- New map field -->
            <div class="row mb-4" id="mapField" style="display: none;">
                <div class="col-sm-12">
                    <div id="map" style="height: 300px;"></div>
                </div>
            </div>
            <div class="row mb-4" id="latField" style="display: none;">
                <label for="lat" class="col-sm-3 col-form-label">Latitude</label>
                <div class="col-sm-9">
                    <input type="number" step="any" class="form-control" id="lat" name="lat" placeholder="Enter Latitude">
                </div>
            </div>
            <div class="row mb-4" id="longField" style="display: none;">
                <label for="long" class="col-sm-3 col-form-label">Longitude</label>
                <div class="col-sm-9">
                    <input type="number" step="any" class="form-control" id="long" name="long" placeholder="Enter Longitude">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-4"> <!-- Flexbox for bottom-right positioning -->
        <button type="submit" class="btn btn-primary w-md event-create-button">Submit</button>
    </div>
</form>

<script>
    // Initialize the map
    var map = L.map('map').setView([51.505, -0.09], 13);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    // Add a marker
    var marker = L.marker([51.5, -0.09], { draggable: true }).addTo(map);

    // Function to update marker position and input fields
    function updateMarker(lat, lng) {
        marker.setLatLng([lat, lng]).update();
        map.setView([lat, lng], 13);
        document.getElementById('lat').value = lat;
        document.getElementById('long').value = lng;
        reverseGeocode(lat, lng);
    }

    // Function to reverse geocode coordinates to get address
    function reverseGeocode(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('offline_address').value = data.display_name;
            })
            .catch(error => console.error('Error:', error));
    }

    // Function to forward geocode address to get coordinates
    function forwardGeocode(address) {
        fetch(`https://nominatim.openstreetmap.org/search?q=${address}&format=json&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    var lat = data[0].lat;
                    var lon = data[0].lon;
                    updateMarker(lat, lon);
                }
            });
    }

    // Event listener for mode selection
    document.getElementById('mode').addEventListener('change', function() {
        var onlineFields = document.getElementById('onlineFields');
        var offlineFields = document.getElementById('offlineFields');
        var mapField = document.getElementById('mapField');
        var latField = document.getElementById('latField');
        var longField = document.getElementById('longField');

        if (this.value === "1") { // Online selected
            onlineFields.style.display = 'flex'; // Change to flex for inline
            offlineFields.style.display = 'none';
            mapField.style.display = 'none';
            latField.style.display = 'none';
            longField.style.display = 'none';
        } else { // Offline selected
            onlineFields.style.display = 'none';
            offlineFields.style.display = 'flex'; // Change to flex for inline
            mapField.style.display = 'none'; // Hide map initially
            latField.style.display = 'none'; // Hide lat field
            longField.style.display = 'none'; // Hide long field
        }
    });

    // Event listener for map button
    document.getElementById('showMapButton').addEventListener('click', function() {
        var mapField = document.getElementById('mapField');
        if (mapField.style.display === 'none' || mapField.style.display === '') {
            mapField.style.display = 'block';
        } else {
            mapField.style.display = 'none';
        }
        map.invalidateSize(); // Resize map after display
    });

    // Function to search address using Nominatim
    function nominatimSearch(query) {
        fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    var suggestions = data.map(place => ({
                        display_name: place.display_name,
                        lat: place.lat,
                        lon: place.lon
                    }));
                    displaySuggestions(suggestions);
                }
            });
    }

function displaySuggestions(suggestions) {
    var suggestionBox = document.getElementById('suggestionBox');
    suggestionBox.innerHTML = '';

    if (suggestions.length === 0) {
        suggestionBox.classList.remove('visible'); // Hide suggestion box if no suggestions
        return;
    }

    suggestionBox.classList.add('visible'); // Show suggestion box if there are suggestions

    suggestions.forEach(suggestion => {
        var suggestionItem = document.createElement('div');
        suggestionItem.textContent = suggestion.display_name;
        suggestionItem.classList.add('suggestion-item');
        suggestionItem.addEventListener('click', function() {
            document.getElementById('offline_address').value = suggestion.display_name;
            updateMarker(suggestion.lat, suggestion.lon);
            suggestionBox.innerHTML = '';
            suggestionBox.classList.remove('visible'); // Hide suggestions after selection
        });
        suggestionBox.appendChild(suggestionItem);
    });
}

document.getElementById('offline_address').addEventListener('input', function() {
    var query = this.value;
    var suggestionBox = document.getElementById('suggestionBox');

    if (query.length > 3) {
        nominatimSearch(query);
    } else {
        suggestionBox.classList.remove('visible'); // Hide suggestion box if input is less than 4 characters
    }
});


    // Click event on map to get coordinates
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lon = e.latlng.lng;
        updateMarker(lat, lon);
    });

    // Drag event on marker to get coordinates
    marker.on('dragend', function(e) {
        var lat = e.target.getLatLng().lat;
        var lon = e.target.getLatLng().lng;
        updateMarker(lat, lon);
    });
</script>
