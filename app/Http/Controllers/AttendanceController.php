<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of all attendances (Admin).
     */
    public function index()
    {
        $attendances = Attendance::latest()->get();
        return response()->json($attendances);
    }

    /**
     * Store a newly created attendance in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invitation_slug' => 'required|string',
            'guest_name' => 'required|string|max:255',
            'attendance' => 'required|string',
            'message' => 'nullable|string',
        ]);

        // Security Check: Validate Token
        $apiKey = $request->header('X-API-KEY');
        $invitation = \App\Models\Invitation::where('slug', $validated['invitation_slug'])
            ->where('api_key', $apiKey)
            ->first();

        if (!$invitation) {
            return response()->json(['message' => 'Invalid API Key or Slug'], 401);
        }

        $attendance = Attendance::create($validated);

        return response()->json([
            'message' => 'RSVP submitted successfully',
            'data' => $attendance
        ], 201);
    }

    /**
     * Display the specified attendance by invitation slug (Client).
     */
    public function showBySlug($slug)
    {
        $attendances = Attendance::where('invitation_slug', $slug)
            ->latest()
            ->get();

        return response()->json($attendances);
    }
}
