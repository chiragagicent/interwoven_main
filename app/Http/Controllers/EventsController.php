<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
class EventsController extends Controller
{
    public function index()
    {
        $events = DB::table('events')->get();
        return view('events.index')->with('events', $events);
    }

    public function create()
    {
        return view('modals.event_create_modal');
    }

    public function store(Request $request)
    {
       /*  $request->validate([
            'title' => 'required|max:100',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'description' => 'required',
        ]); */

        DB::table('events')->insert([
            'event_id'=>$request->event_id,
            'admin_id' => "1", // You may want to change this to the currently logged-in user ID
            'title' => $request->title,
            'media_url' => $request->media_url,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'description' => $request->description,
            'mode' => $request->mode,
            'online_url' => $request->online_url,
            'offline_address' => $request->offline_address,
            'lat' => $request->lat,
            'long' => $request->long,
            'created_datetime' => now(),
            'updated_datetime' => now(),
        ]);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }
}
