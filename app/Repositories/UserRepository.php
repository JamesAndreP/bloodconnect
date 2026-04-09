<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findById(int $id): User
    {
        return User::find($id);
    }

    public function update(array $data): bool
    {
        $user = User::where('id', $data['user_id'])->first();
        if ($data['password']) {
            $user->update([
                'password' => $data['password'],
            ]);
        }
        return $user
            ->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'location' => $data['location'] ?? null,
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'phone' => $data['phone'] ?? null,
                'status' => $data['status'],
            ]);
    }

    public function delete(int $id): int
    {
        return User::where('id', $id)->delete();
    }
}
