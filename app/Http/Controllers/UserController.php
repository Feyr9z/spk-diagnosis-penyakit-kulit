<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('User/Index', [
            'users' => $this->userService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->store($request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): RedirectResponse
    {
        $user = $this->userService->findById($id);

        if (! $user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan.');
        }

        return redirect()->route('users.index')->with('info', 'Fitur edit akan diselesaikan pada tahap berikutnya.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        $user = $this->userService->findById($id);

        if (! $user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan.');
        }

        $this->userService->update($user, $request->validated());

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = $this->userService->findById($id);

        if (! $user) {
            return redirect()->route('users.index')->with('error', 'User tidak ditemukan.');
        }

        $this->userService->delete($user);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
