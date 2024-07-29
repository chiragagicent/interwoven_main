<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Helpers\AdminHelper;

class EventsController extends Controller
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
    
}
