<?php

namespace App\Repositories\Contracts;

interface BloodRequestRepositoryInterface
{
    public function all();
    public function allByHospital();
    public function find(int $id);
    public function create(array $data);
    public function fulfill(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
}
