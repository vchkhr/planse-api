<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\ArrangementController;

class EventController extends Controller
{
    public function index()
    {
        $events = array();

        $arrangements = app(ArrangementController::class)->index();
        if ($arrangements != null) {
            foreach ($arrangements as $arrangement) {
                $arrangement->type = 'arrangement';
                array_push($events, $arrangement);
            }
        }

        $reminders = app(ReminderController::class)->index();
        if ($reminders != null) {
            foreach ($reminders as $reminder) {
                $reminder->type = 'reminder';
                array_push($events, $reminder);
            }
        }

        return $events;
    }

    public function destroy(Event $event)
    {
        
    }
}
