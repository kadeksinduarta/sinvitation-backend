<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function index()
    {
        return response()->json(Invitation::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengantin' => 'required|string',
        ]);

        // Auto-generate slug dari nama pengantin
        $baseSlug = Str::slug($validated['nama_pengantin']);
        $slug = $baseSlug;
        $counter = 1;

        // Pastikan slug unik, jika sudah ada tambahkan angka di belakang
        while (Invitation::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $invitation = Invitation::create([
            'slug' => $slug,
            'nama_pengantin' => $validated['nama_pengantin'],
            'api_key' => 'sv_' . Str::random(40),
        ]);

        return response()->json($invitation, 201);
    }

    public function destroy($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->delete();

        return response()->json(['message' => 'Invitation deleted']);
    }
}
