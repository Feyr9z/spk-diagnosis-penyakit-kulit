<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $totalDiagnosis = Diagnosis::count();
        $totalGejala    = Gejala::count();
        $totalPenyakit  = Penyakit::count();
        $totalUser      = User::count();

        $diagnosisTerbaru = Diagnosis::with(['penyakit'])
            ->latest()
            ->limit(5)
            ->get();

        $penyakitTerbanyak = Diagnosis::selectRaw('penyakit_id, COUNT(*) as total')
            ->with('penyakit')
            ->groupBy('penyakit_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'total_diagnosis' => $totalDiagnosis,
                'total_gejala'    => $totalGejala,
                'total_penyakit'  => $totalPenyakit,
                'total_user'      => $totalUser,
            ],
            'diagnosis_terbaru'    => $diagnosisTerbaru,
            'penyakit_terbanyak'   => $penyakitTerbanyak,
        ]);
    }
}
