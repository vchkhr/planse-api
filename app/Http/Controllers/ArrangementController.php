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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function show(Arrangement $arrangement)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arrangement $arrangement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arrangement  $arrangement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arrangement $arrangement)
    {
        //
    }
}
