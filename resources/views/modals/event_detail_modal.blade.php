
 <div class="row">
    <div class="col-md-6">
        <div class="mb-3">
             <img src="{{ $event->media_url ? asset('storage/' . $event->media_url) : asset('assets/images/small/img-1.jpg') }}" alt="Event Image" class="img-thumbnail" />            
        </div>
    </div>
    <div class="col-md-6">
        <div>
            <label class="form-label" for="eventId">Event ID</label>
            <input type="text" class="form-control" id="eventId" placeholder="Event ID" value="{{ $event->event_id }}" readonly>
        </div>
        <div>
            <label class="form-label" for="eventTitle">Title</label>
            <input type="text" class="form-control" id="eventTitle" placeholder="Event Title" value="{{ $event->title }}" readonly>
        </div>
        <div>
            <label class="form-label" for="eventDate">Date</label>
            <input type="text" class="form-control" id="eventDate" placeholder="Event Date" value="{{ $event->date }}" readonly>
        </div>
        <div>
            <label class="form-label" for="eventStartTime">Start Time</label>
            <input type="text" class="form-control" id="eventStartTime" placeholder="Start Time" value="{{ $event->start_time }}" readonly>
        </div>
        <div>
            <label class="form-label" for="eventDescription">Description</label>
            <textarea class="form-control" id="eventDescription" placeholder="Description" readonly>{{ $event->description }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-1">
            <label class="form-label" for="eventMode">Mode</label>
            <input type="text" class="form-control" id="eventMode" placeholder="Mode" value="{{ $event->mode == 1 ? 'Online' : 'Offline' }}" readonly>
        </div>
    </div>

    <div class="col-md-6" id="onlineUrlField" style="{{ $event->mode ? 'display: block;' : 'display: none;' }}">
        <div class="mb-1">
            <label class="form-label" for="eventOnlineUrl">Online URL</label>
            <input type="text" class="form-control" id="eventOnlineUrl" placeholder="Online URL" value="{{ $event->online_url }}" readonly>
        </div>
    </div>

    <div class="col-md-6" id="offlineAddressField" style="{{ !$event->mode ? 'display: block;' : 'display: none;' }}">
        <div class="mb-1">
            <label class="form-label" for="eventOfflineAddress">Offline Address</label>
            <input type="text" class="form-control" id="eventOfflineAddress" placeholder="Offline Address" value="{{ $event->offline_address }}" readonly>
        </div>
    </div>

    <div class="col-md-6" id="latitudeField" style="{{ !$event->mode ? 'display: block;' : 'display: none;' }}">
        <div class="mb-1">
            <label class="form-label" for="eventLat">Latitude</label>
            <input type="text" class="form-control" id="eventLat" placeholder="Latitude" value="{{ $event->lat }}" readonly>
        </div>
    </div>

    <div class="col-md-6" id="longitudeField" style="{{ !$event->mode ? 'display: block;' : 'display: none;' }}">
        <div class="mb-1">
            <label class="form-label" for="eventLong">Longitude</label>
            <input type="text" class="form-control" id="eventLong" placeholder="Longitude" value="{{ $event->long }}" readonly>
        </div>
    </div>
</div>

<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        var mode = {{ $event->mode }};
        var onlineUrlField = document.getElementById('onlineUrlField');
        var offlineAddressField = document.getElementById('offlineAddressField');
        var latitudeField = document.getElementById('latitudeField');
        var longitudeField = document.getElementById('longitudeField');

        if (mode) {
            onlineUrlField.style.display = 'block';
            offlineAddressField.style.display = 'none';
            latitudeField.style.display = 'none';  
            longitudeField.style.display = 'none'; 
        } else {
            onlineUrlField.style.display = 'none';
            offlineAddressField.style.display = 'block';
            latitudeField.style.display = 'block';  
            longitudeField.style.display = 'block'; 
        }
    });
</script>
