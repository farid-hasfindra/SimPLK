<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = Dokter::with('user')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'spesialisasi' => 'required|string|max:100',
            'no_sip' => 'required|string|max:50',
            'tarif_dasar' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'dokter',
            ]);

            Dokter::create([
                'user_id' => $user->id,
                'spesialisasi' => $request->spesialisasi,
                'no_sip' => $request->no_sip,
                'tarif_dasar' => $request->tarif_dasar,
            ]);
        });

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokter $dokter)
    {
        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $dokter->user_id,
            'spesialisasi' => 'required|string|max:100',
            'no_sip' => 'required|string|max:50',
            'tarif_dasar' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $dokter) {
            $dokter->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $dokter->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $dokter->update([
                'spesialisasi' => $request->spesialisasi,
                'no_sip' => $request->no_sip,
                'tarif_dasar' => $request->tarif_dasar,
            ]);
        });

        return redirect()->route('admin.dokter.index')->with('success', 'Data Dokter berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        // Deleting the user will cascade delete the dokter profile
        $dokter->user->delete();
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
