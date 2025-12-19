<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class HewanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hewans = Hewan::with('pelanggan.user')->get();
        return view('admin.hewan.index', compact('hewans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = Pelanggan::with('user')->get();
        return view('admin.hewan.create', compact('pelanggans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'nama_hewan' => 'required|string|max:100',
            'jenis_hewan' => 'required|string|max:50',
            'ras' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
        ]);

        Hewan::create($request->all());

        return redirect()->route('admin.hewans.index')->with('success', 'Data hewan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hewan $hewan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hewan $hewan)
    {
        $pelanggans = Pelanggan::with('user')->get();
        return view('admin.hewan.edit', compact('hewan', 'pelanggans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hewan $hewan)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'nama_hewan' => 'required|string|max:100',
            'jenis_hewan' => 'required|string|max:50',
            'ras' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $hewan->update($request->all());

        return redirect()->route('admin.hewans.index')->with('success', 'Data hewan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hewan $hewan)
    {
        $hewan->delete();
        return redirect()->route('admin.hewans.index')->with('success', 'Data hewan berhasil dihapus.');
    }
}
