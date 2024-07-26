


 <div class="modal-body user-details-content ">
    @forelse($groupInfo as $group)
        <div class="card bg-primary border-primary text-white-50 mb-3">
            <div class="card-body">
                <h5 class="mb-3 text-white" style="font-size: 12px;">User Id</h5>
                <p class="card-text" style="font-size: 12px;">{{ $group->user_id}}</p>
                <h5 class="mb-3 text-white" style="font-size: 12px;">Group Name</h5>
                <p class="card-text" style="font-size: 12px;">{{ $group->group_name }}</p>
                <h5 class="mb-3 text-white" style="font-size: 12px;">Group ID</h5>
                <p class="card-text" style="font-size: 12px;">{{ $group->group_id }}</p>
                <h5 class="mb-3 text-white" style="font-size: 12px;">Total Members</h5>
                <p class="card-text" style="font-size: 12px;">{{ $group->total_members }}</p>
                <h5 class="mb-3 text-white" style="font-size: 12px;">Description</h5>   
                <p class="card-text" style="font-size: 12px;">{{ $group->description }}</p>

            </div>
        </div>
    @empty
        <p>No groups found for this user.</p>
    @endforelse
</div>
