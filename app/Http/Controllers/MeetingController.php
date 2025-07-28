<?php
namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index($projectId)
    {
        $project = Project::with('meetings')->findOrFail($projectId);
        return view('reunion.index', compact('project'));
    }

    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        return view('reunion.create', compact('project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'nullable|date',
        ]);

        $roomName = 'reunion_' . $request->project_id . '_' . uniqid();

        $meeting = Meeting::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'room_name' => $roomName,
            'start_time' => $request->start_time,
            'description' => $request->description,
        ]);

        return redirect()->route('meetings.index', $meeting->project_id)
                         ->with('success', 'Réunion créée avec succès.');
    }

    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('reunion.show', compact('meeting'));
    }
}
