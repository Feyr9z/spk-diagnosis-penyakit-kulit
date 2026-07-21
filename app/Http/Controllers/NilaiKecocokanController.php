<?php

namespace App\Http\Controllers;

use App\Http\Requests\NilaiKecocokan\StoreNilaiKecocokanRequest;
use App\Http\Requests\NilaiKecocokan\UpdateNilaiKecocokanRequest;
use App\Models\NilaiKecocokan;
use App\Services\NilaiKecocokanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NilaiKecocokanController extends Controller
{
    public function __construct(
        protected NilaiKecocokanService $nilaiKecocokanService
    ) {}

    public function index(): Response
    {
        return Inertia::render('NilaiKecocokan/Index', [
            'penyakit' => $this->nilaiKecocokanService->getAllPenyakit(),
            'gejala' => $this->nilaiKecocokanService->getAllGejala(),
            'nilaiKecocokan' => $this->nilaiKecocokanService->getAll(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('NilaiKecocokan/Create', [
            'penyakit' => $this->nilaiKecocokanService->getAllPenyakit(),
            'gejala' => $this->nilaiKecocokanService->getAllGejala(),
        ]);
    }

    public function store(StoreNilaiKecocokanRequest $request): RedirectResponse
    {
        $this->nilaiKecocokanService->store($request->validated());

        return redirect()
            ->route('nilai-kecocokan.index')
            ->with('success', 'Nilai kecocokan berhasil ditambahkan.');
    }

    public function edit(NilaiKecocokan $nilaiKecocokan): Response
    {
        return Inertia::render('NilaiKecocokan/Edit', [
            'nilaiKecocokan' => $nilaiKecocokan->load(['penyakit', 'gejala']),
            'penyakit' => $this->nilaiKecocokanService->getAllPenyakit(),
            'gejala' => $this->nilaiKecocokanService->getAllGejala(),
        ]);
    }

    public function update(UpdateNilaiKecocokanRequest $request, NilaiKecocokan $nilaiKecocokan): RedirectResponse
    {
        $this->nilaiKecocokanService->update($nilaiKecocokan, $request->validated());

        return redirect()
            ->route('nilai-kecocokan.index')
            ->with('success', 'Nilai kecocokan berhasil diperbarui.');
    }

    public function destroy(NilaiKecocokan $nilaiKecocokan): RedirectResponse
    {
        $this->nilaiKecocokanService->delete($nilaiKecocokan);

        return redirect()
            ->route('nilai-kecocokan.index')
            ->with('success', 'Nilai kecocokan berhasil dihapus.');
    }

    public function updateMatrix(Request $request)
    {
        $data = $request->validate([
            'matrix' => 'required|array',
            'matrix.*.penyakit_id' => 'required|exists:penyakit,id',
            'matrix.*.gejala_id' => 'required|exists:gejala,id',
            'matrix.*.nilai' => 'required|numeric|min:0|max:255',
        ]);

        foreach ($data['matrix'] as $item) {
            NilaiKecocokan::updateOrCreate(
                ['penyakit_id' => $item['penyakit_id'], 'gejala_id' => $item['gejala_id']],
                ['nilai' => $item['nilai']]
            );
        }

        return redirect()->back()->with('success', 'Matriks nilai kecocokan berhasil diperbarui.');
    }
}
