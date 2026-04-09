<?php

namespace App\Repositories\Contracts;

use App\Models\Hospital;

interface HospitalRepositoryInterface
{
    public function create(array $data): Hospital;
    public function update(array $data): bool;
    public function delete(int $id): int;
    public function getAll();
    public function findById(int $id);
    public function findNearestHospital(string $lat, string $long);
    public function findNearbyHospitals(string $lat, string $long);
}
