<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Helpers\AdminHelper;

class UserController extends Controller
{
    public function index() {
        $users = User::getUsersDetails();
        $divToShow = 0;
            $formCount = 0;
            return view('users.users')
                ->with('users', $users)
                ->with('divToShow' ,$divToShow)
                ->with('formCount' ,$formCount);
    }

    public function getGroupDetails($id) {
        $groupInfo = DB::table('users_groups')
            ->join('users', 'users_groups.user_id', '=', 'users.user_id')
            ->where('users_groups.user_id', $id)
            ->select('users_groups.group_id', 'users_groups.name as group_name', 'users_groups.total_members', 'users_groups.description','users_groups.user_id')
            ->get();

        if (!$groupInfo) {
            return response()->json(['error' => 'Group not found'], 404);
        }

        return view('modals.user_group_modal')->with('groupInfo', $groupInfo);
    }
     public function getUserDetails($id)
    {
    $users = User::getUserDetails($id);

    if (!$users) {
        return response()->json(['error' => 'User not found'], 404);
    }

    return view('modals.user_detail_modal')->with('users', $users);
    }

    public function userSearch(Request $request){
        $inputValue = $request->all();
        $searchIn = $request->search_in;
        // dd($inputValue);


        for ($i = 0; $i < count($searchIn); $i++) {
          if ($searchIn[$i] == 'block_flag' || $searchIn[$i] == 'created_datetime' || $searchIn[$i]=='sign_via'||$searchIn[$i]=='user_type') {
            $searchType[$i] = 'exact_match';
          } else {
            $searchType[$i] = $request->search_type[$i];
          }
        }

        $suggestionText = $request->suggestion_text;

        //$isVerified = $request->block_flag;
        

        $formCount = $request->formCount;
        $divToShow = $request->divToShow;
        $limitFlag = $request->limit_flag;
        $dateFilters = $request->datefilter;
        $startDate = array();
        $endDate = array();

        foreach ($dateFilters as $dateFilter) {
          if ($dateFilter != "") {
              $splitDateFilter = explode(' ~ ', $dateFilter);
              $startDateFilter = $splitDateFilter[0] . " 00:00:00";

            // echo '<pre>';
            // print_r($startDateFilter);
              //$startDateFilterFormat = date("Y/m/d H:i:s", strtotime($startDateFilter));
              $startDateFilterFormat = date("m/d/Y H:i:s", strtotime($startDateFilter));


              $endDateFilter = $splitDateFilter[1] . " 23:59:59";

              //$endDateFilterFormat = date("Y/m/d H:i:s", strtotime($endDateFilter));
              $endDateFilterFormat = date("m/d/Y H:i:s", strtotime($endDateFilter));

              //$timezone = 'America/Los_Angeles';
              $timezone = Session::get('timezone');

              $start_date = AdminHelper::ConvertLocalTimezoneToGMT($startDateFilterFormat, $timezone);
              $end_date = AdminHelper::ConvertLocalTimezoneToGMT($endDateFilterFormat, $timezone);
          } else {
              $start_date = '';
              $end_date = '';
          } 

          $startDate[] = $start_date;
          $endDate[] = $end_date;

        } 
        
        $userType = $request->user_type;
        $data = User::getUserSearchData($searchIn, $searchType, $suggestionText, $startDate, $endDate, $limitFlag,$userType);
        // // $countData = AdmUser::countUserData();


        return view('users.users')
            ->with('users', $data)
            ->with('divToShow' ,$divToShow)
            ->with('inputValue',$inputValue)
            ->with('searchType',$searchType)
            ->with('searchIn',$searchIn)
            ->with('formCount' ,$formCount);
            

        
    }

/*     public function blockUser($id)
      {

          // Retrieve the current status of the user
          $user = DB::table('users')
                      ->select('users.is_blocked')
                      ->where('users.user_id', $id)
                      ->first();

          if ($user) {
              // Toggle the is_blocked status
              $newStatus = $user->is_blocked ? 0 : 1;

              // Update the is_blocked status in the database
              DB::table('users')->where('users.user_id', $id)->update(['users.is_blocked' => $newStatus]);

              return back()->with('success', 'User status updated successfully.');
          }

          return back()->with('error', 'User not found.');
      } */

      public function blockUser($id)
{
    try {
        // Retrieve the current status of the user
        $user = DB::table('users')
                    ->select('users.is_blocked') // Specify the table name
                    ->where('user_id', $id)
                    ->first();

        if ($user) {
            // Toggle the is_blocked status
            $newStatus = $user->is_blocked ? 0 : 1;

            // Update the is_blocked status in the database
            DB::table('users')->where('user_id', $id)->update(['is_blocked' => $newStatus]);

            return back()->with('success', 'User status updated successfully.');
        }

        return back()->with('error', 'User not found.');
    } catch (\Exception $e) {
        // Log the exception and return an error message
        \Log::error('Error updating user status: ' . $e->getMessage());
        return back()->with('error', 'An error occurred while updating the user status.');
    }
}


    
}
