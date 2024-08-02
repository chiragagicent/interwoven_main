{{-- partials/user_details.blade.php --}}
{{-- @if(isset($user)) --}}
<style>
  .avatar-l {
    width: 150px; 
    height: 150px; 
    object-fit: cover;
    border-radius: 50%; 
  }
</style>
<div class="text-center mb-4">
    
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $users->profile_pic ? asset('storage/' . $users->profile_pic) :'assets/images/users/avatar-2.jpg' }}" alt="User Image" class="mx-4 rounded-circle avatar-l">

        </div>
        <div class="col-md-6 ">
            <div class="mb-3">
                <label class="form-label" for="userUsername">User ID</label>
                <input type="text" class="form-control" id="userUsername" placeholder="Username" value="{{ $users->userid}}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label" for="userName">Name</label>
                <input type="text" class="form-control" id="userName" placeholder="Full name" value="{{ $users->name }}" readonly>
            </div>
        </div>
    </div>  
</div>
<div class="row">
    

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
    
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userEmail">City</label>
            <input type="text" class="form-control" id="userEmail" placeholder="Email" value="{{ $users->city }}" readonly>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="userEmail">Zip Code</label>
            <input type="text" class="form-control" id="userEmail" placeholder="Email" value="{{ $users->zip_code }}" readonly>
        </div>
    </div>
</div>
