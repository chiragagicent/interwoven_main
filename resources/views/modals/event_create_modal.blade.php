<form id="eventCreateForm">
    @csrf <!-- Include CSRF token for security -->
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
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="offline_address" name="offline_address" placeholder="Enter Offline Address">
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
    document.getElementById('mode').addEventListener('change', function() {
        var onlineFields = document.getElementById('onlineFields');
        var offlineFields = document.getElementById('offlineFields');
        var latField = document.getElementById('latField');
        var longField = document.getElementById('longField');

        if (this.value === "1") { // Online selected
            onlineFields.style.display = 'flex'; // Change to flex for inline
            offlineFields.style.display = 'none';
            latField.style.display = 'none';
            longField.style.display = 'none';
        } else { // Offline selected
            onlineFields.style.display = 'none';
            offlineFields.style.display = 'flex'; // Change to flex for inline
            latField.style.display = 'flex'; // Change to flex for inline
            longField.style.display = 'flex'; // Change to flex for inline
        }
    });
</script>
