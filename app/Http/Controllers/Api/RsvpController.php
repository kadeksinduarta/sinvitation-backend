<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|string',
            'nama_tamu' => 'required|string|max:255',
            'jumlah_kehadiran' => 'required|integer|min:1',
            'status_kehadiran' => 'required|in:hadir,tidak_hadir',
        ]);

        $invitation = \App\Models\Invitation::where('slug', $request->slug)->first();

        if (!$invitation) {
            return response()->json(['message' => 'Undangan tidak ditemukan'], 404);
        }

        $rsvp = $invitation->rsvps()->create([
            'nama_tamu' => $request->nama_tamu,
            'jumlah_kehadiran' => $request->jumlah_kehadiran,
            'status_kehadiran' => $request->status_kehadiran,
        ]);

        return response()->json([
            'message' => 'Terima kasih atas konfirmasi kehadiran Anda',
            'data' => $rsvp
        ], 201);
    }

    public function index(Request $request)
    {
        // Admin or dashboard needs to view all rsvps, optionally filtered by invitation
        $query = \App\Models\Rsvp::with('invitation');

        if ($request->has('slug')) {
            $query->whereHas('invitation', function($q) use ($request) {
                $q->where('slug', $request->slug);
            });
        }

        $rsvps = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $rsvps->count(),
            'hadir' => $rsvps->where('status_kehadiran', 'hadir')->sum('jumlah_kehadiran'),
            'tidak_hadir' => $rsvps->where('status_kehadiran', 'tidak_hadir')->count(),
        ];

        return response()->json([
            'data' => $rsvps,
            'stats' => $stats
        ]);
    }
}
