{{-- partials/user_details.blade.php --}}
{{-- @if(isset($user)) --}}
<div class="text-center mb-4">
    <img src="{{ $users->profile_pic }}" alt="{{ $users->name }}" class="img-thumbnail rounded-circle" width="150">
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userName">Name</label>
            <input type="text" class="form-control" id="userName" placeholder="Full name" value="{{ $users->name }}" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userUsername">User ID</label>
            <input type="text" class="form-control" id="userUsername" placeholder="Username" value="{{ $users->userid}}" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userPhoneNumber">Contact number</label>
            <input type="text" class="form-control" id="userPhoneNumber" placeholder="Phone number" value="{{ $users->contact_info}} " readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userEmail">Email</label>
            <input type="text" class="form-control" id="userEmail" placeholder="Email" value="{{ $users->email_id }}" readonly>
        </div>
    </div>
        <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userEmail">Address</label>
            <input type="text" class="form-control" id="userEmail" placeholder="Email" value="{{ $users->address }}" readonly>
        </div>
    </div>
    </div>
        <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userEmail">City</label>
            <input type="text" class="form-control" id="userEmail" placeholder="Email" value="{{ $users->city }}" readonly>
        </div>
    </div>
     </div>
        <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userEmail">Zip Code</label>
            <input type="text" class="form-control" id="userEmail" placeholder="Email" value="{{ $users->zip_code }}" readonly>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Followers</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->total_followers }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Following</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->total_following }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Bio</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->bio }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Keywords</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->keywords }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Characteristics</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->characteristics }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Date of Birth</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->dob }}</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <h5 class="card-header bg-transparent border-bottom text-uppercase">Created At</h5>
            <div class="card-body">
                <h4 class="card-title">{{ $user->created_datetime }}</h4>
            </div>
        </div>
    </div>
</div>

 --}}