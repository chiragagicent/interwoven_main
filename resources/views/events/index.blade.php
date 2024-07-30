
@extends('layouts.master')
@section('content')
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

            <div class="row">
                @foreach ($events as $event)
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="assets/images/small/img-1.jpg" alt="Card image cap">
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title">{{ $event->title }}</h4>
                            <p class="card-text">{{ $event->description }}</p>
                            <div class="mt-auto d-flex justify-content-between text-muted opacity-75">
                                <div>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($event->created_datetime)->format('Y-m-d') }} <!-- Convert to Carbon -->
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


$(document).on('submit', '#eventCreateForm', function(event) {
    event.preventDefault(); // Prevent default form submission

    $.ajax({
        type: 'POST',
        url: '{{ route('events.store') }}', // Update with your route
        data: $(this).serialize(), // Serialize form data
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

});
</script>
@endsection