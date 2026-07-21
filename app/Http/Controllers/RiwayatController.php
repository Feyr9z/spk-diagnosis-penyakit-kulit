<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RiwayatController extends Controller
{
    public function index(): Response
    {
        $riwayat = Diagnosis::with(['pasien', 'penyakit'])
            ->latest()
            ->get();

        return Inertia::render('Riwayat/Index', [
            'riwayat' => $riwayat,
        ]);
    }

    public function show(Diagnosis $diagnosis): Response
    {
        $diagnosis->load(['pasien', 'penyakit', 'details.gejala']);

        return Inertia::render('Riwayat/Show', [
            'diagnosis' => $diagnosis,
        ]);
    }

    public function destroy(Diagnosis $diagnosis): RedirectResponse
    {
        $diagnosis->delete();

        return redirect()
            ->route('riwayat.index')
            ->with('success', 'Riwayat diagnosis berhasil dihapus.');
    }
}
