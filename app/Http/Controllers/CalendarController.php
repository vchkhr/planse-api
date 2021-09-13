<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{
    public function create()
    {
        //
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

    public function show(Request $request, Calendar $calendar)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $calendar = $user->calendars()->find($request->id);

        if ($calendar == null) {
            return response([
                'message' => 'You can\'t see this calendar.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $calendar;
    }

    public function index(Calendar $calendar)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $calendars = $user->calendars()->get();

        return $calendars;
    }

    public function edit(Calendar $calendar)
    {
        //
    }

    public function update(Request $request, Calendar $calendar)
    {
        $data = request()->validate([
            'color' => ['nullable'],
            'name' => ['nullable', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $calendar = $user->calendars()->find($request->id);

        if ($calendar == null) {
            return response([
                'message' => 'You can\'t edit this calendar.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $calendar->update([
            'color' => $data['color'] ?? $calendar['color'],
            'name' => $data['name'] ?? $calendar['name'],
            'description' => $data['description'] ?? $calendar['description'],
        ]);

        return response($calendar);
    }

    public function destroy(Calendar $calendar)
    {
        //
    }
}
