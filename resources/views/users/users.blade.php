@extends('layouts.master')

@section('content')
<style>
    .avatar-md{
        width: 30px;
        height:30px;
        margin-left: 20%;
        }

    .btn-search
    {
        width: 70%;
        height: 60%;
        margin-top: 14%;
        margin-left: 20%;    
    }

    .btn-font 
    {
        font-size: 19px;
       
    }

    .plus-icon-new 
    {
        font-size: 35px;
        font-weight: bold;
        
    }

    .limit-box 
    {
        margin-left: 180px;
        width: 90px;
        height: 55%;
    }

    .limit-label 
    {
        margin-left: 180px;
    }

    .search-text 
    {
        width:100%;
        height: 50px;
        margin-left: 30px;
    }

    .search-label 
    {
        margin-left: 30px;
    }

    .filter-btn 
    {
        margin-left: 229px;
    }

    .filter-dropdown {
            position: relative;
        }

    .filter-dropdown .dropdown-menu {
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
        }

    .text-underline {
        text-decoration: underline;
    }
       
    .bg-light-danger {
    background-color: rgba(255, 0, 0, 0.1); /* Light red background */
}

   
</style>

<div class="main-content">
    <div class="page-content">
        <!-- start search row -->
        <div class="row mt-10">
               <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        {!! Form::open(['url' => '/users', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                        <?php for ($i = 0; $i <= 3; $i++) { ?>
                            <div class="col-lg-12" id="filter_{{$i}}" @if($i!=0) style="display:none;" @endif>
                                <div class="row">
                                    <div class="col-lg-2 form-group">
                                        {!! Form::label('search_in', 'Search In') !!}
                                        <select name="search_in[{{$i}}]" id = "search_in_{{$i}}" data-id="{{$i}}" class="search_in js-states form-control select2-selection__rendered" tabindex="-1" style="width: 100%">
                                            <option value="name" @if(isset($inputValue) && ($inputValue['search_in'][$i]=='name' )){{{ "selected" }}} @endif> Name</option>
                                            <option value="email_id" @if(isset($inputValue) && ($inputValue['search_in'][$i]=='email_id' )){{{ "selected" }}} @endif>Email ID</option>
                                            <option value="created_datetime" @if(isset($inputValue) && ($inputValue['search_in'][$i]=='created_datetime' )){{{ "selected" }}} @endif>Created At</option>
                                            <option value="contact_info" @if(isset($inputValue) && ($inputValue['search_in'][$i]=='contact_info' )){{{ "selected" }}} @endif>Contact Info</option>
                                           
                                           {{--
                                            <option value="block_flag" @if(isset($inputValue) && ($inputValue['search_in'][$i]=='block_flag' )){{{ "selected" }}} @endif>Is Verified </option>
                                            --}} 
                                           {{-- <option value="is_verified" @if(isset($inputValue) && ($inputValue['search_in'][$i] == 'is_verified')){{{ "selected" }}} @endif >Is Active </option> --}}
                                            <option value="user_type" @if(isset($inputValue) && ($inputValue['search_in'][$i]=='user_type' )){{{ "selected" }}} @endif>User Type</option>
                                            
                                        </select>
                                    </div>

                                    <div class="col-lg-2 form-group form-group-search">
                                        {!! Form::label('search_type', 'Search Type') !!}
                                        <select name="search_type[{{$i}}]" id="search_type_{{$i}}" class="js-states form-control select2-selection__rendered" tabindex="-1" style="width: 100%">
                                            <option value="contains" @if(isset($inputValue) && ($searchType[$i]=='contains' )){{{ "selected" }}} @endif>Contains</option>
                                            <option value="begins_with" @if(isset($inputValue) && ($searchType[$i]=='begins_with' )){{{ "selected" }}} @endif>Begins With</option>
                                            <option value="ends_with" @if(isset($inputValue) && ($searchType[$i]=='ends_with' )){{{ "selected" }}} @endif>Ends With</option>
                                            <option value="exact_match" @if(isset($inputValue) && ($searchType[$i]=='exact_match' )){{{ "selected" }}} @endif>Exact Match</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 form-group form-group-search">
                                        <span id="suggestion_text_span_{{$i}}">
                                            {!! Form::label('suggestion_text', 'Enter Text') !!}
                                            <input type="text" name="suggestion_text[{{$i}}]" value="<?php if (isset($inputValue)) {
                                            echo $inputValue['suggestion_text'][$i];
                                            } ?>" class='form-control suggestion_text{{$i}}' id='suggestion_venue_{{ $i }}' onblur='trim(this)' maxlength='255' autocomplete='off'>
                                            <span id="display_suggestion_venue_list" style="position:absolute;margin-top:-1px;display:none;overflow:hidden;background-color:white; z-index:9; width:97%"></span>
                                        </span>

                                        <span id="block_flag_span_{{$i}}" style="display:none;">
                                            {!! Form::label('Block', 'Select') !!}
                                            <select name="block_flag[{{$i}}]" id="block_flag_{{$i}}" class="js-states form-control" tabindex="-1" style="width:100%; height:38px;">
                                                <option value="Any">Any</option>
                                                <option value="1" @if(isset($inputValue) && ($inputValue['block_flag'][$i]=='1' )){{{ "selected" }}} @endif>Yes</option>
                                                <option value="0" @if(isset($inputValue) && ($inputValue['block_flag'][$i]=='0' )){{{ "selected" }}} @endif>No</option>
                                            </select>
                                        </span>

                                        <span id="user_type_span_{{$i}}" style="display:none;">
                                                    {!! Form::label('user_type', 'User Type') !!}
                                                    <select name="user_type[{{$i}}]" id="user_type_{{$i}}" class="js-states form-control" tabindex="-1" style="width:100%; height:38px;">
                                                        <option value="Any">Any</option>
                                                        <option value="1" @if(isset($inputValue) && ($inputValue['user_type'][$i]=='1' )){{{ "selected" }}} @endif>High School Students</option>
                                                        <option value="2" @if(isset($inputValue) && ($inputValue['user_type'][$i]=='2' )){{{ "selected" }}} @endif>High School Professionals</option>
                                                        <option value="3" @if(isset($inputValue) && ($inputValue['user_type'][$i]=='3' )){{{ "selected" }}} @endif>College Students</option>
                                                        <option value="4" @if(isset($inputValue) && ($inputValue['user_type'][$i]=='4' )){{{ "selected" }}} @endif>College Professionals</option>
                                                        <option value="5" @if(isset($inputValue) && ($inputValue['user_type'][$i]=='5' )){{{ "selected" }}} @endif>Parents/Caregivers</option>
                                                    </select>
                                        </span>


                                        
                                        {{-- <span id="is_verified_span_{{$i}}" style="display:none;">
                                            {!! Form::label('Active', 'Select') !!}
                                            <select name="is_verified[{{$i}}]" id="is_verified_{{$i}}" class="js-states form-control" tabindex="-1" style="width:100%; height:38px;">
                                                <option value="Any">Any</option>
                                                <option value="1" @if(isset($inputValue) && ($inputValue['is_verified'][$i]=='1' )){{{ "selected" }}} @endif>Yes</option>
                                                <option value="0" @if(isset($inputValue) && ($inputValue['is_verified'][$i]=='0' )){{{ "selected" }}} @endif>No</option>
                                            </select>
                                        </span> --}}

                                        <span id="date_range_span_{{$i}}" style="display: none; width: 100%;">
                                            {!! Form::label('date_range', 'Date Range') !!} (m/d/Y)
                                            <input type="text" class="form-control date-range-piker-field date_range{{$i}}" name="datefilter[{{$i}}]" id="datepicker-range" value="<?php if (isset($inputValue)) {
                                                                                                                                                                echo $inputValue['datefilter'][$i];
                                                                                                                                                                } ?>" readonly required>
                                        </span>
                                    </div>
                                    <div class="col-lg-2 form-group form-group-search" style="margin-top:20px !important">
                                        @if($i == 0)
                                        <button type="button" class="btn btn-primary btn-addon add-filter criteria-btn mt-2" id="{{$i}}"><i class="fa fa-plus" style="margin-right: 4px; font-weight: bold;"></i>Criteria</button>
                                        @else
                                        <button type="button" class="btn btn-danger remove-filter criteria-btn mt-3" id="{{$i}}"><i class="fa fa-times" style="margin-right: 4px; font-weight: bold;"></i> Criteria</button>
                                        @endif
                                    </div>

                                    @if($i==0)
                                    <!-- <div class="col-md-1"></div> -->
                                    <div class="col-lg-1 form-group form-group-search" style="padding: 0;">
                                        {!! Form::label('Limit', 'Limit') !!}
                                        <select name="limit_flag" id="limit_flag" class="js-states form-control" tabindex="-1">
                                            <option value="50" @if(isset($inputValue) && ($inputValue['limit_flag']==50) || isset($default_limit)){{{ "selected" }}} @endif>50</option>
                                            <option value="100" @if(isset($inputValue) && ($inputValue['limit_flag']==100)){{{ "selected" }}} @endif>100</option>
                                            <option value="200" @if(isset($inputValue) && ($inputValue['limit_flag']==200)){{{ "selected" }}} @endif>200</option>
                                            <option value="500" @if(isset($inputValue) && ($inputValue['limit_flag']==500)){{{ "selected" }}} @endif>500</option>
                                            <option value="1000" @if(isset($inputValue) && ($inputValue['limit_flag']==1000)){{{ "selected" }}} @endif>1000</option>
                                            <option value="2000" @if(isset($inputValue) && ($inputValue['limit_flag']==2000)){{{ "selected" }}} @endif>2000</option>
                                            {{-- <option value="" @if(isset($inputValue) && ($inputValue['limit_flag']=="" )){{{ "selected" }}} @endif>All</option> --}}
                                        </select>
                                    </div>
                                    <div class="col-lg-2 form-group form-group-search" style="margin-top:12px !important">
                                        <button type="submit" class="btn btn-primary btn-addon m-y-sm seach-filter-btn mt-3 ms-2"style="width:130px;" ><i class="fa fa-search" style="margin-right: 4px;"></i> Filter/Apply</button>
                                    </div>
                                    
                                    @endif
                                </div>
                            </div>
                        <?php } ?>

                        <input type="hidden" name="divToShow" id="divToShow" value="{{ $divToShow }}">
                        <input type="hidden" name="formCount" id="formCount" value="{{ $formCount }}">
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
 <!--end search row-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">User Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">User Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">User Details</h4>
                            <p class="card-title-desc">This table shows detailed user information including address, groups, and contact information.</p>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-bordered">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="user-details" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Profile Pic</th>
                                                    <th>Name</th>
                                                    <th>User Type</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Contact Info</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                     <tr style="background-color: {{ $user->is_blocked ? 'lightcoral' : 'transparent' }};">                                                       
                                                        <td><img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/images/users/avatar-2.jpg') }}" alt="User Image" class="mx-4 rounded-circle avatar-md "></td>
                                                        <td><a class="user-group-details" data-id="{{ $user->userid }}" style="cursor:pointer">{{ $user->name }}</a></td>
                                                        <td>{{ $user->user_type_label }}</td>
                                                        <td>{{ $user->email_id }}</td>
                                                        <td>{{ $user->address }}</td>
                                                        <td>{{ $user->contact_info }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-dark" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">  
                                                                    <i class="bx bx-dots-vertical"></i>
                                                                </a>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <li><a class="dropdown-item view-user-details" href="#" data-id="{{$user->userid }}">View</a></li>
                                                                    {{-- <li>
                                                                        <form action="#" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="dropdown-item">Delete</button>
                                                                        </form>
                                                                    </li> --}}
                                                                    <li>
                                                                        <form action="/users/block/{{ $user->userid }}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            @if ($user->is_blocked)
                                                                                <button type="submit" class="dropdown-item">Unblock</button>
                                                                            @else
                                                                                <button type="submit" class="dropdown-item">Block</button>
                                                                            @endif
                                                                        </form>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" style="z-index: 10000; margin-top:50px;" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body user-details-content">
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
            $('#user-details').DataTable();

            $(document).on('click', '.user-group-details', function(e){
                e.preventDefault();
                var user_id = $(this).data('id');
                if(user_id != '') {
                    // Send AJAX request
                    $.ajax({
                        type: 'GET',
                        url: `/user_details/${user_id}`,
                        success: function(response) {
                            $('#userModal').modal('show');
                            $('#userModal .user-details-content').html(response);  
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
            $(document).on('click', '.view-user-details', function(e){
                e.preventDefault();
                var user_id = $(this).data('id');
                if(user_id != '') {
                    // Send AJAX request
                    $.ajax({
                        type: 'GET',
                        url: `/user_details/${user_id}`,
                        success: function(response) {
                            $('#userModal').modal('show');
                            $('#userModal .user-details-content').html(response);  
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
            

            // start script for search
                var divsToShow = $('#divToShow').val().split(',');

                for (i = 0; i <= divsToShow.length; i++) {

                    $('#filter_' + divsToShow[i]).show();
                }

                $(document).on('change', '.search_in', function() {
                    var id = $(this).attr('data-id');
                    var search_in = $('#search_in_' + id).val();
                    showHideSpan(search_in, id);
                });

                var formCount = $('#formCount').val();
                
                for (i = 0; i <= 3; i++) {
                        var search_in = $('#search_in_' + i).val();
                        showHideSpan(search_in, i);
                }

                if (formCount == 4) {
                    $('.add-filter').attr('disabled', 'true');
                }

                $(document).on('click', '.add-filter', function() {
                var formCount = $('#formCount').val();

                if (formCount < 4) {

                    formCount++;
                    $('#formCount').val(formCount);

                    if (formCount == 4) {
                        $('.add-filter').attr('disabled', 'true');
                    }

                    var divToShow = $('#divToShow').val();

                    var divArrayToShow = divToShow.split(',');

                    for (i = 0; i <= 4; i++) {

                        if ($('#filter_' + i).is(":visible")) {

                        } else {

                            $('#filter_' + i).show();

                            if (jQuery.inArray(i, divArrayToShow) == -1) {

                                if (divToShow != '') {
                                    $('#divToShow').val(divToShow + ',' + i);
                                } else {
                                    $('#divToShow').val(i);
                                }
                            }

                            return false;
                        }
                    }
                }

                });


                $(document).on('click', '.remove-filter', function() {
                var index = $(this).attr('id');
                $('#filter_' + index).hide();
                var formCount = $('#formCount').val();
                formCount--;

                var divString = $('#divToShow').val();

                var divArrayToHide = divString.split(',');

                var divArrayToHide = jQuery.grep(divArrayToHide, function(value) {
                    return value != index;
                });

                var divStringToHide = divArrayToHide.toString();
                $('#divToShow').val(divStringToHide);
                $('#formCount').val(formCount);

                $('.add-filter').removeAttr('disabled');
                $('#user_type_' + index).val('Any').change();
                //$('#active_flag_'+i).val('Any').change();
                $('#block_flag_' + index).val('Any').change();
                //   $('#report_flag_'+i).val('Any').change();
                $('.date_range' + index).val('');
                $('.suggestion_text' + index).val('');
                });
                // end script for search
            });


                $(function() {

                for (i = 0; i <= 3; i++) {

                $('.date_range' + i).daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        //format: 'DD-MM-YYYY'
                        format: 'MM/DD/YYYY'
                    }
                });

                $('.date_range' + i).on('apply.daterangepicker', function(ev, picker) {
                    //$(this).val(picker.startDate.format('DD-MM-YYYY') + ' ~ ' + picker.endDate.format('DD-MM-YYYY'));
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' ~ ' + picker.endDate.format('MM/DD/YYYY'));
                });

                $('.date_range' + i).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                }

                });


                function showHideSpan(search_in, i) {

                if (search_in == 'name' || search_in == 'email_id' || search_in=='contact_info') 
                {
                $('#suggestion_text_span_' + i).css('display', 'block');
                $('#search_type' + i).removeAttr("disabled");
                $('#search_type_' + i).prop('disabled', false);
                $('.suggestion_text_' + i).removeAttr("onkeyup", "checkInput(this)");
                // $('#block_flag_span_' + i).css('display', 'none');
                //$('#block_flag_' + i).val('Any');
                //$('#sign_via_span_' + i).css('display', 'none');
                // $('#gender_flag_span_' + i).val('Any');
                $('#user_type_span_' + i).css('display', 'none');
                $('.user_type' + i).val('Any');
                // $('#report_flag_span_' + i).css('display', 'none');
                // $('#report_flag_' + i).val('Any');
                $('#date_range_span_' + i).css('display', 'none');
                $('.date_range' + i).val('');
                // $('#is_verified_span_' + i).css('display', 'none');
                // $('#is_verified' + i).val('Any');
                // $('#vendor_type_span_' + i).css('display', 'none');

                } 
                else if (search_in == 'created_datetime') {
                $('#block_flag_span_' + i).css('display', 'none');
                $('#block_flag_' + i).val('Any');
                // $('#gender_flag_span_' + i).css('display', 'none');
                // $('#gender_flag_span_' + i).val('Any');
                $('#date_range_span_' + i).css('display', 'block');
                $('#search_type_' + i).attr('disabled', 'disabled');
                $('.suggestion_text' + i).removeAttr("onkeyup", "checkInput(this)");
                $('#search_type_' + i).val('exact_match').change();
                // $('#user_type_span_' + i).css('display', 'none');
                // $('#user_type' + i).val('Any');
                $('#suggestion_text_span_' + i).css('display', 'none');
                $('#is_verified_span_' + i).css('display', 'none');
                $('#is_verified' + i).val('Any');
                // $('#vendor_type_span_' + i).css('display', 'none');
                } else if (search_in == 'block_flag') {
                $('#user_type_span_' + i).css('display', 'none');
                $('#user_type' + i).val('Any');
                $('#sign_via_span_' + i).css('display', 'none');
                $('#sign_via_span_' + i).val('Any');
                $('#block_flag_span_' + i).css('display', 'block');
                $('#search_type_' + i).prop('disabled', true);
                $('.suggestion_text_' + i).removeAttr("onkeyup", "checkInput(this)");
                $('#search_type_' + i).val('exact_match').change();
                $('#suggestion_text_span_' + i).css('display', 'none');
                $('#suggestion_venue_' + i).val('');
                $('.date_range' + i).val('');
                $('#date_range_span_' + i).css('display', 'none');
                // $('#active_flag_span_' + i).css('display', 'none');
                // $('#active_flag' + i).val('Any');
                // $('#vendor_type_span_' + i).css('display', 'none');

                //    $('#search_type_'+i).val('exact_match').css('cursor', 'not-allowed');
                //$('#search_type_'+i).css('cursor', 'not-allowed');
                } else if (search_in == 'is_verified') {
                $('#user_type_span_' + i).css('display', 'none');
                $('#user_type' + i).val('Any');
                $('#is_verified_span_' + i).css('display', 'block');
                // $('#block_flag_span_' + i).css('display', 'none');
                // $('#block_flag_' + i).val('Any');
                // $('#gender_flag_span_' + i).css('display', 'none');
                // $('#gender_flag_span_' + i).val('Any');
                $('#search_type_' + i).prop('disabled', true);
                $('.suggestion_text_' + i).removeAttr("onkeyup", "checkInput(this)");
                $('#search_type_' + i).val('exact_match').change();
                $('#suggestion_text_span_' + i).css('display', 'none');
                $('.date_range' + i).val('');
                $('#date_range_span_' + i).css('display', 'none');
                $('#date_range_span_' + i).css('display', 'none');
                // $('#vendor_type_span_' + i).css('display', 'none');

                } else if (search_in == 'sign_via'){
                $('#user_type_span_' + i).css('display', 'none');
                $('#user_type' + i).val('Any');
                $('#sign_via_span_' + i).css('display', 'block');
                $('#sign_via_span_' + i).val('Any');
                $('#block_flag_span_' + i).css('display', 'none');
                $('#search_type_' + i).prop('disabled', true);
                $('.suggestion_text_' + i).removeAttr("onkeyup", "checkInput(this)");
                $('#search_type_' + i).val('exact_match').change();
                $('#suggestion_text_span_' + i).css('display', 'none');
                $('#suggestion_venue_' + i).val('');
                $('.date_range' + i).val('');
                $('#date_range_span_' + i).css('display', 'none');
                }else if(search_in=='user_type')
                {
                $('#user_type_span_' + i).css('display', 'block'); // Show User Type dropdown
                $('#suggestion_text_span_' + i).css('display', 'none'); // Hide text input
                $('.date_range' + i).val('');
                $('#date_range_span_' + i).css('display', 'none');
                }

                }
        
    </script>
    





@endsection

