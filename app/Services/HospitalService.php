<?php

namespace App\Services;

use App\Enums\UserRoleEnum;
use App\Enums\UserStatusEnum;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\HospitalRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Hash;

class HospitalService
{
    protected $userRepository;
    protected $hospitalRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        HospitalRepositoryInterface $hospitalRepository
    ) {
        $this->userRepository = $userRepository;
        $this->hospitalRepository = $hospitalRepository;
    }

    public function createHospitalWithUser(array $data)
    {
        // Step 1: Create user
        $user = $this->userRepository->create([
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'password' => Hash::make($data['user_password']),
            'role' => UserRoleEnum::HospitalAdmin,
            'location' => $data['user_location'] ?? null,
            'birth_date' => '2000-01-01',
'gender' => 'other',
            'phone' => $data['user_phone'] ?? null,
            'status' => UserStatusEnum::Active,
        ]);

        // Step 2: Create hospital linked to user
        $hospital = $this->hospitalRepository->create([
            'name' => $data['hospital_name'],
            'location' => $data['hospital_location'],
            'user_id' => $user->id,
        ]);

        return $hospital;
    }

    public function updateHospitalWithUser(array $data)
{
    $existingUser = $this->userRepository->findById($data['user_id']);

    // Step 1: update user
    $this->userRepository->update([
        'user_id' => $data['user_id'],
        'name' => $data['user_name'],
        'email' => $data['user_email'],
        'password' => $data['user_password'] ? Hash::make($data['user_password']) : null,
        'birth_date' => $data['user_birth_date'] ?? $existingUser->birth_date,
        'gender' => $data['user_gender'] ?? $existingUser->gender,
        'phone' => $data['user_phone'],
        'status' => $data['user_status'],
    ]);

    // Step 2: update hospital linked to user
    $hospital = $this->hospitalRepository->update([
        'hospital_id' => $data['hospital_id'],
        'name' => $data['hospital_name'],
        'location' => $data['hospital_location'],
    ]);

    return $hospital;
}

    public function delete(int $id)
    {
        $hospital = $this->findById($id);
        $this->userRepository->delete($hospital->user->id);
        return $this->hospitalRepository->delete($id);
    }

    public function getAll()
    {
        return $this->hospitalRepository->getAll();
    }

    public function findById(int $id)
    {
        return $this->hospitalRepository->findById($id);
    }

    public function findNearestHospital($lat, $long)
    {
        return $this->hospitalRepository->findNearestHospital($lat, $long);
    }
}
