<?php

namespace App\Services;

use App\Repositories\Contracts\BloodInventoryRepositoryInterface;

class BloodInventoryService
{
    protected $repository;

    public function __construct(
        BloodInventoryRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function getAll()
    {
        $result = $this->repository->all();
        $mapped = $result->pluck('current_quantity', 'blood_type');
        return $mapped;
    }

    public function create($data)
    {
        return $this->repository->create($data);
    }

    public function deduct($data)
    {
        return $this->repository->deduct($data);
    }
}
