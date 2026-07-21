<?php

namespace App\Http\Controllers;

use App\Http\Requests\Diagnosis\StoreDiagnosisRequest;
use App\Models\Diagnosis;
use App\Services\DiagnosisService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DiagnosisController extends Controller
{
    public function __construct(
        protected DiagnosisService $diagnosisService
    ) {}

    public function index(): RedirectResponse
    {
        return redirect()->route('diagnosis.create');
    }

    public function create(): Response
    {
        return Inertia::render('Diagnosis/Create', [
            'gejala' => $this->diagnosisService->getAllGejala(),
        ]);
    }

    public function store(StoreDiagnosisRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $diagnosis = $this->diagnosisService->proses(
            pasienData: [
                'nama'          => $validated['nama'],
                'usia'          => $validated['usia'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
            ],
            selectedGejalaIds: $validated['gejala_ids'],
        );

        return redirect()
            ->route('diagnosis.show', $diagnosis->id)
            ->with('success', 'Diagnosis berhasil dilakukan.');
    }

    public function show(Diagnosis $diagnosis): Response
    {
        $diagnosisFull = $this->diagnosisService->findWithRelations($diagnosis->id);

        return Inertia::render('Diagnosis/Show', [
            'diagnosis' => $diagnosisFull,
        ]);
    }
}
