<?php

namespace App\Http\Controllers;

use App\Http\Requests\Gejala\StoreGejalaRequest;
use App\Http\Requests\Gejala\UpdateGejalaRequest;
use App\Models\Gejala;
use App\Services\GejalaService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GejalaController extends Controller
{
    public function __construct(
        protected GejalaService $gejalaService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Gejala/Index', [
            'gejala' => $this->gejalaService->getAll(),
            'total_bobot' => Gejala::sum('bobot'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Gejala/Create', [
            'total_bobot' => Gejala::sum('bobot'),
        ]);
    }

    public function store(StoreGejalaRequest $request): RedirectResponse
    {
        $this->gejalaService->store($request->validated());

        return redirect()
            ->route('gejala.index')
            ->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala): Response
    {
        return Inertia::render('Gejala/Edit', [
            'gejala' => $gejala,
            'total_bobot' => Gejala::sum('bobot'),
        ]);
    }

    public function update(UpdateGejalaRequest $request, Gejala $gejala): RedirectResponse
    {
        $this->gejalaService->update($gejala, $request->validated());

        return redirect()
            ->route('gejala.index')
            ->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $gejala): RedirectResponse
    {
        $this->gejalaService->delete($gejala);

        return redirect()
            ->route('gejala.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }
}
