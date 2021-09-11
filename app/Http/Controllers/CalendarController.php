<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function create()
    {
        // return view('questions/store');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'color' => ['nullable'],
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $calendar = $user->calendars()->create([
            'color' => $data['color'] ?? 0,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return response($calendar);
    }

    public function show(Calendar $calendar)
    {
        return $calendar;
    }

    public function edit(Calendar $calendar)
    {
        //
    }

    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    public function destroy(Calendar $calendar)
    {
        //
    }
}
