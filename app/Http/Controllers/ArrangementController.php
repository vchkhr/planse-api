<?php

namespace App\Http\Controllers;

use App\Models\Arrangement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ArrangementController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $calendar = $user->calendars->find($request->id);

        if ($calendar == null) {
            return response([
                'message' => 'You can\'t see this calendar.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $arrangements = $calendar->arrangements;

        return $arrangements;
    }

    public function date_compare($element1, $element2) {
        $datetime1 = strtotime($element1['end']);
        $datetime2 = strtotime($element2['end']);
        return $datetime1 - $datetime2;
    } 

    public function all_day($element1, $element2) {
        return $element2['all_day'] - $element1['all_day'];
    } 

    public function indexUser()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $calendars = $user->calendars;

        $arrangements = Array();

        foreach ($calendars as $calendar) {
            foreach ($calendar->arrangements as $arrangement) {
                array_push($arrangements, $arrangement);
            }
        }

        usort($arrangements, array($this, 'date_compare'));
        usort($arrangements, array($this, 'all_day'));

        return $arrangements;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'calendar_id' => ['required', 'integer'],
            'start' => ['required', 'date_format:Y-m-d H:i:s'],
            'end' => ['required', 'date_format:Y-m-d H:i:s'],
            'all_day' => ['boolean', 'nullable'],
            'color' => ['nullable'],
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

        if (strtotime($data['start']) > strtotime($data['end'])) {
            return response([
                'message' => 'End date should be after start date.'
            ], Response::HTTP_I_AM_A_TEAPOT);
        }

        $arrangement = $calendar->arrangements()->create([
            'user_id' => $user->id,
            'start' => $data['start'],
            'end' => $data['end'],
            'all_day' => $data['all_day'] ?? false,
            'color' => $data['color'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return response($arrangement);
    }

    public function show(Request $request, Arrangement $arrangement)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $arrangement = $user->arrangements()->find($request->id);

        if ($arrangement == null) {
            return response([
                'message' => 'You can\'t see this arrangement.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $arrangement;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function edit(Arrangement $arrangement)
    {
        //
    }

    public function update(Request $request, Arrangement $arrangement)
    {
        $data = request()->validate([
            'calendar_id' => ['nullable', 'integer'],
            'start' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'end' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'all_day' => ['boolean', 'nullable'],
            'color' => ['nullable'],
            'name' => ['nullable', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $arrangement = $user->arrangements()->find($request->id);

        if ($arrangement == null) {
            return response([
                'message' => 'You can\'t edit this arrangement.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $arrangement->update([
            'calendar_id' => $data['calendar_id'] ?? $arrangement['calendar_id'],
            'start' => $data['start'] ?? $arrangement['start'],
            'end' => $data['end'] ?? $arrangement['end'],
            'all_day' => $data['all_day'] ?? $arrangement['all_day'],
            'color' => $data['color'] ?? $arrangement['color'],
            'name' => $data['name'] ?? $arrangement['name'],
            'description' => $data['description'] ?? $arrangement['description'],
        ]);

        return response($arrangement);
    }

    public function destroy(Request $request, Arrangement $arrangement)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $arrangement = $user->arrangements()->find($request->id);

        if ($arrangement == null) {
            return response([
                'message' => 'You can\'t delete this arrangement.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $arrangement->delete();

        return response([], Response::HTTP_OK);
    }
}
