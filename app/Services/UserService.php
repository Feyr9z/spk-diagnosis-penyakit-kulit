<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    public function findById(string|int $id): ?User
    {
        return User::find($id);
    }

    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        if (isset($data['password']) && $data['password'] !== '') {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->fill($data);
        $user->save();

        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
