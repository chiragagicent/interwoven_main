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
    public function show(Event $event) {
        
    return view('modals.event_detail_modal')->with('event', $event);
    }
    public function edit($id)
    {
        $event = DB::table('events')->where('event_id', $id)->first();
        return view('modals.event_edit_modal')->with('event', $event);
    }

        public function update(Request $request, $id)
        {
            $data = $request->except(['_token', '_method']); // Exclude CSRF token and method fields

            if ($request->hasFile('media_url')) {
                $file = $request->file('media_url');
                $path = $file->store('media', 'public'); // Store the image in the 'public/media' directory
                $data['media_url'] = $path; // Save the file path to the media_url field
            }

            // Update the event in the database using DB Query Builder
            DB::table('events')->where('event_id', $id)->update($data);
            
            return redirect()->route('events.index')->with('success', 'Event updated successfully!');
        }

    public function destroy($id)
    {
        DB::table('events')->where('event_id', $id)->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function store(Request $request)
    {
/*         // Debug information
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('media', 'public'); // Store in 'storage/app/public/media' directory
            dd($path); // Debugging: Output the path to check if the file is uploaded correctly
        } else {
            dd('No file uploaded'); // Debugging: Output message if no file is uploaded
        } */

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('media', 'public'); // Store in 'storage/app/public/media' directory
        }
        DB::table('events')->insert([
            'event_id'=>$request->event_id,
            'admin_id' => "1", 
            'title' => $request->title,
            //'media_url' => $request->media_url,
            'date'=>$request->date,
            'media_url' => $path ?? 'assets/images/small/img-1.jpg',
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
