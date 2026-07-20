<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penyakit\StorePenyakitRequest;
use App\Http\Requests\Penyakit\UpdatePenyakitRequest;
use App\Models\Penyakit;
use App\Services\PenyakitService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PenyakitController extends Controller
{
    public function __construct(
        protected PenyakitService $penyakitService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Penyakit/Index', [
            'penyakit' => $this->penyakitService->getAll(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Penyakit/Create');
    }

    public function store(StorePenyakitRequest $request): RedirectResponse
    {
        $this->penyakitService->store($request->validated());

        return redirect()
            ->route('penyakit.index')
            ->with('success', 'Penyakit berhasil ditambahkan.');
    }

    public function edit(Penyakit $penyakit): Response
    {
        return Inertia::render('Penyakit/Edit', [
            'penyakit' => $penyakit,
        ]);
    }

    public function update(UpdatePenyakitRequest $request, Penyakit $penyakit): RedirectResponse
    {
        $this->penyakitService->update($penyakit, $request->validated());

        return redirect()
            ->route('penyakit.index')
            ->with('success', 'Penyakit berhasil diperbarui.');
    }

    public function destroy(Penyakit $penyakit): RedirectResponse
    {
        $this->penyakitService->delete($penyakit);

        return redirect()
            ->route('penyakit.index')
            ->with('success', 'Penyakit berhasil dihapus.');
    }
}
