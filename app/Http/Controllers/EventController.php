<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\ArrangementController;

class EventController extends Controller
{
    public function index()
    {
        $arrangements = app(ArrangementController::class)->index();

        foreach ($arrangements as $arrangement) {
            $arrangement->type = 'arrangement';
        }

        $events = $arrangements;

        return $events;
    }

    public function destroy(Event $event)
    {
        
    }
}
