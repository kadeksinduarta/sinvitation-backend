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
            'slug' => 'required|string|unique:invitations,slug',
            'nama_pengantin' => 'required|string',
        ]);

        $invitation = Invitation::create([
            'slug' => $validated['slug'],
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
