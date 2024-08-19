<?php

namespace App\Http\Controllers\Admin;
use App\Models\Event;
use Carbon\Carbon;

class HomeController
{
    public function index(Event $event)
    {
        $events = Event::where('visualization', '1')
        ->whereDate('end', '>=', Carbon::now()->toDateString())
        ->orderBy('id', 'desc')
        ->get();

        foreach ($events as $ev) {
            $ev->invited = $event->attendanceCount($ev->id);
            $ev->checkIn = $event->attendanceCheckInCount($ev->id);
        }

        return view('home', compact('events'));
    }
}
