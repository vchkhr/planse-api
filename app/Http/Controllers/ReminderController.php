<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReminderController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $reminders = array();

        $calendars = $user->calendars;

        foreach ($calendars as $calendar) {
            if ($calendar->reminders != null) {
                foreach ($calendar->reminders as $reminder) {
                    array_push($reminders, $reminder);
                }
            }
        }

        usort($reminders, array($this, 'date_compare'));
        usort($reminders, array($this, 'all_day'));

        return $reminders;
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'calendar_id' => ['required', 'integer'],
            'start' => ['required', 'date_format:Y-m-d H:i:s'],
            'all_day' => ['nullable', 'boolean'],
            'color' => ['nullable', 'integer'],
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $calendar = $user->calendars()->find($data['calendar_id']);

        if ($calendar == null) {
            return response([
                'message' => 'You can\'t add to this calendar.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $reminder = $calendar->reminders()->create([
            'user_id' => $user->id,
            'start' => $data['start'],
            'all_day' => $data['all_day'] ?? false,
            'color' => $data['color'] ?? 0,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return response($reminder);
    }

    public function show(Request $request, reminder $reminder)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $reminder = $user->reminders()->find($request->id);

        if ($reminder == null) {
            return response([
                'message' => 'You can\'t see this reminder.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $reminder;
    }

    public function update(Request $request, reminder $reminder)
    {
        $data = request()->validate([
            'calendar_id' => ['nullable', 'integer'],
            'start' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'all_day' => ['nullable', 'boolean'],
            'color' => ['nullable', 'integer'],
            'name' => ['nullable', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $reminder = $user->reminders()->find($request->id);

        if ($reminder == null) {
            return response([
                'message' => 'You can\'t edit this reminder.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $reminder->update([
            'calendar_id' => $data['calendar_id'] ?? $reminder['calendar_id'],
            'start' => $data['start'] ?? $reminder['start'],
            'all_day' => $data['all_day'] ?? $reminder['all_day'],
            'color' => $data['color'] ?? $reminder['color'],
            'name' => $data['name'] ?? $reminder['name'],
            'description' => $data['description'] ?? $reminder['description'],
        ]);

        return response($reminder);
    }

    public function destroy(Request $request, reminder $reminder)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $reminder = $user->reminders()->find($request->id);

        if ($reminder == null) {
            return response([
                'message' => 'You can\'t delete this reminder.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $reminder->delete();

        return response([], Response::HTTP_OK);
    }

    public function date_compare($element1, $element2)
    {
        $datetime1 = strtotime($element1['start']);
        $datetime2 = strtotime($element2['start']);
        return $datetime1 - $datetime2;
    }

    public function all_day($element1, $element2)
    {
        return $element2['all_day'] - $element1['all_day'];
    }
}
