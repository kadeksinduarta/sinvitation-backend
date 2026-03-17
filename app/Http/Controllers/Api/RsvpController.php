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

    /**
     * Get attendance by slug (public route with slug parameter)
     */
    public function getBySlug($slug)
    {
        $invitation = \App\Models\Invitation::where('slug', $slug)->first();

        if (!$invitation) {
            return response()->json(['message' => 'Undangan tidak ditemukan'], 404);
        }

        $rsvps = $invitation->rsvps()->orderBy('created_at', 'desc')->get();

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

    /**
     * Admin: Get all attendance data
     */
    public function index(Request $request)
    {
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

    /**
     * Admin: Update RSVP entry
     */
    public function update(Request $request, $id)
    {
        $rsvp = \App\Models\Rsvp::findOrFail($id);

        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'jumlah_kehadiran' => 'required|integer|min:1',
            'status_kehadiran' => 'required|in:hadir,tidak_hadir',
        ]);

        $rsvp->update($validated);

        return response()->json([
            'message' => 'Data RSVP berhasil diperbarui',
            'data' => $rsvp
        ]);
    }

    /**
     * Admin: Delete RSVP entry
     */
    public function destroy($id)
    {
        $rsvp = \App\Models\Rsvp::findOrFail($id);
        $rsvp->delete();

        return response()->json([
            'message' => 'Data RSVP berhasil dihapus'
        ]);
    }
}
