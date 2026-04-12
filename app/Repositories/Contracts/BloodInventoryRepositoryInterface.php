<?php

namespace App\Repositories\Contracts;

interface BloodInventoryRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function deduct(array $data);
}
