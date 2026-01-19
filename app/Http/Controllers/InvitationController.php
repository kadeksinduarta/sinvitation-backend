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
            'client_name' => 'required|string',
        ]);

        $invitation = Invitation::create([
            'slug' => $validated['slug'],
            'client_name' => $validated['client_name'],
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
