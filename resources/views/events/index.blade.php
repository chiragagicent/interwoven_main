
@extends('layouts.master')
@section('content')
<style>
#offline_address {
    border: none; /* Remove the default border */
    box-shadow: none; /* Remove box shadow */
    padding-bottom: 5px; /* Optional: Add some padding to the bottom */
}

#offline_address:focus {
    outline: none; /* Remove the default outline */
    border-bottom: 1px transparent gray; /* Change border color on focus */
}

.suggestion-box {
    display: none; /* Initially hide the suggestion box */
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    position: absolute;
    z-index: 1000;
    background-color: #fff;
    width: 100%;
}

.suggestion-box.visible {
    display: block; /* Show the suggestion box only when it has the 'active' class */
}
.suggestion-item {
    padding: 8px;
    cursor: pointer;
}

.suggestion-item:hover {
    background-color: #f0f0f0;
}
.card img {
    width: 100%; /* Make the image fill the card width */
    height: 200px; /* Set a fixed height for the card */
    object-fit: cover; /* Crop the image to fill the area */
    border-radius: 8px; /* Optional: add some rounded corners */
}


</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Events</h4>
                        <div class="page-title-right">
                            <button type="button" class="btn btn-primary event-create-modal">Create Event</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                @foreach ($events as $event)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                        <div class="card-body d-flex flex-column">
                            <div>
                                 <div class="dropdown">
                                 <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="bx bx-dots-vertical"></i>
                                 </a>
                                 <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                     <li><a class="dropdown-item view-user-details" href="#">View</a></li>
                                     <li>
                                         <form action="#" method="POST" style="display: inline;">
                                             <button type="submit" class="dropdown-item">Delete</button>
                                         </form>
                                     </li>
                                     <li>
                                         <form action="#" method="POST" style="display: inline;">
                                                 <button type="submit" class="dropdown-item">Block</button>
                                         </form>
                                     </li>
                                 </ul>
                                </div>  
                            </div>
                            <h4 class="card-title">{{ $event->title }}</h4>
                          
                            <p class="card-text">{{ $event->description }}</p>
                            <div class="mt-auto d-flex justify-content-between text-muted opacity-75">
                                <div>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($event->created_datetime)->format('Y-m-d') }} 
                                </div>
                                <div>
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $event->start_time }}
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light mt-3">Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> --}}
            <div class="row">
    @foreach ($events as $event)
            <div class="col-md-4">
                <div class="card">
                    <img class="card-img-top img-fluid" src="{{ $event->media_url ? asset('storage/' . $event->media_url) : 'assets/images/small/img-1.jpg' }}" alt="Card image cap">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h4 class="card-title">{{ $event->title }}</h4>
                            <div class="dropdown">
                                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item view-event-details" href="#" data-id="{{$event->event_id}}">View</a></li>
                                        <li>
                                                <form action="{{ route('events.destroy', $event->event_id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this event?');">Delete</button>
                                                </form>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item edit-event-details" data-id="{{$event->event_id}}">Edit</a>
                                        </li>
                                </ul>
                            </div>
                        </div>
                        <p class="card-text">{{ $event->description }}</p>
                        <div class="mt-auto d-flex justify-content-between text-muted opacity-75">
                            <div>
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($event->created_datetime)->format('Y-m-d') }}
                            </div>
                            <div>
                                <i class="fas fa-clock me-1"></i>
                                {{ $event->start_time }}
                            </div>
                        </div>
                        <a  class="btn btn-primary waves-effect waves-light mt-3 view-event-details" href="#" data-id="{{$event->event_id}}" >Details</a>
                    </div>
                </div>
            </div>
    @endforeach
</div>




        </div>
    </div>


    <div class="modal fade bs-example-modal-xl" id="eventModal" tabindex="-1" style="z-index: 10000; margin-top:50px;" role="dialog"aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Event Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body event-create">
                    <!-- Dynamic user details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-xl" id="eventDetailModal" tabindex="-1" style="z-index: 10000; margin-top:50px;" role="dialog"aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body event-detail">
                    <!-- Dynamic event details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-xl" id="eventEditModal" tabindex="-1" style="z-index: 10000; margin-top:50px;" role="dialog"aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Event Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body event-edit">
                    <!-- Event details to be edited will be loaded here -->
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
@section('javascript')

<script>
  
$(document).ready(function() {

$(document).on('click', '.event-create-modal', function(e) {
    e.preventDefault();
    
    // Send AJAX request
    $.ajax({
        type: 'GET',
        url: `/events/create`,
        success: function(response) {
            console.log('Response:', response); // Log the response
            $('#eventModal ').modal('show');
            $('#eventModal .event-create').html(response);  
        },
        error: function(error) {
            console.error('Error:', error);
            alert('An error occurred while loading the modal.'); // Notify about the error
        }
    });
});


/* $(document).on('submit', '#eventCreateForm', function(event) {
    event.preventDefault(); 

    $.ajax({
        type: 'POST',
        url: '{{ route('events.store') }}',
        data: $(this).serialize(), 
        success: function(response) {
            $('#eventModal').modal('hide'); 
            location.reload(); 
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
}); */
$(document).on('submit', '#eventCreateForm', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Create a FormData object
    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: '{{ route('events.store') }}', // Update with your route
        data: formData,
        contentType: false, // Important for file upload
        processData: false, // Important for file upload
        success: function(response) {
            $('#eventModal').modal('hide'); // Hide the modal
            // Optionally, you can refresh the events list here or display a success message
            location.reload(); // Reload the page to see the new event
        },
        error: function(error) {
            console.error('Error:', error);
        }
    });
});


$(document).on('click', '.view-event-details', function(e) {
    e.preventDefault();
    
    var eventId = $(this).data('id'); // Get the event ID from the clicked element

    // Send AJAX request
    $.ajax({
        type: 'GET',
        url: `/events/${eventId}`, // Use the event ID in the URL
        success: function(response) {
            console.log('Response:', response); // Log the response
            $('#eventDetailModal').modal('show');
            $('#eventDetailModal .event-detail').html(response);  
        },
        error: function(error) {
            console.error('Error:', error);
            alert('An error occurred while loading the modal.'); // Notify about the error
        }
    });
});

$(document).on('click', '.edit-event-details', function(e) {
    e.preventDefault();
    
    var eventId = $(this).data('id'); // Get the event ID from the clicked element

    // Send AJAX request
    $.ajax({
        type: 'GET',
        url: `/events/${eventId}/edit`, // Use the event ID in the URL
        success: function(response) {
            console.log('Response:', response); // Log the response
            $('#eventEditModal').modal('show');
            $('#eventEditModal .event-edit').html(response);  
        },
        error: function(error) {
            console.error('Error:', error);
            alert('An error occurred while loading the modal.'); // Notify about the error
        }
    });
});
    document.getElementById('eventEditForm').addEventListener('submit', function(event) {
        console.log("Form submitted");
        // Optionally log the form data
        const formData = new FormData(event.target);
        for (const [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });

});
</script>
@endsection