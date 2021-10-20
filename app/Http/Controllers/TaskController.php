<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $tasks = array();

        $calendars = $user->calendars;

        foreach ($calendars as $calendar) {
            if ($calendar->tasks != null) {
                foreach ($calendar->tasks as $task) {
                    array_push($tasks, $task);
                }
            }
        }

        usort($tasks, array($this, 'date_compare'));
        usort($tasks, array($this, 'is_done'));

        return $tasks;
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'calendar_id' => ['required', 'integer'],
            'start' => ['required', 'date_format:Y-m-d H:i:s'],
            'is_done' => ['nullable', 'boolean'],
            'color' => ['nullable', 'integer'],
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $calendar = $user->calendars()->find($data['calendar_id']);

        if ($calendar == null) {
            return response([
                'message' => 'You can not add tasks to this calendar.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $task = $calendar->tasks()->create([
            'user_id' => $user->id,
            'start' => $data['start'],
            'is_done' => $data['is_done'] ?? false,
            'color' => $data['color'] ?? 0,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return response($task);
    }

    public function show(Request $request, task $task)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $task = $user->tasks()->find($request->id);

        if ($task == null) {
            return response([
                'message' => 'You can not see this task.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $task;
    }

    public function update(Request $request, task $task)
    {
        $data = request()->validate([
            'calendar_id' => ['nullable', 'integer'],
            'start' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'is_done' => ['nullable', 'boolean'],
            'color' => ['nullable', 'integer'],
            'name' => ['nullable', 'max:100'],
            'description' => ['nullable', 'max:200'],
        ]);

        /** @var \App\Models\User */
        $user = Auth::user();

        $task = $user->tasks()->find($request->id);

        if ($task == null) {
            return response([
                'message' => 'You can not edit this task.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $task->update([
            'calendar_id' => $data['calendar_id'] ?? $task['calendar_id'],
            'start' => $data['start'] ?? $task['start'],
            'is_done' => $data['is_done'] ?? $task['is_done'],
            'color' => $data['color'] ?? $task['color'],
            'name' => $data['name'] ?? $task['name'],
            'description' => $data['description'] ?? $task['description'],
        ]);

        return response($task);
    }

    public function destroy(Request $request, task $task)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $task = $user->tasks()->find($request->id);

        if ($task == null) {
            return response([
                'message' => 'You can not delete this task.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $task->delete();

        return response([], Response::HTTP_OK);
    }

    public function date_compare($element1, $element2)
    {
        $datetime1 = strtotime($element1['start']);
        $datetime2 = strtotime($element2['start']);
        return $datetime1 - $datetime2;
    }

    public function is_done($element1, $element2)
    {
        return $element1['is_done'] - $element2['is_done'];
    }
}
