<?php

namespace App\Services;

use App\Repositories\Contracts\BloodRequestRepositoryInterface;

class BloodRequestService
{
    protected $repository;

    public function __construct(
        BloodRequestRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getAllByHospital()
    {
        return $this->repository->allByHospital();
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    public function create($data)
    {
        return $this->repository->create($data);
    }

    public function fulfill($id)
    {
        return $this->repository->fulfill($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
