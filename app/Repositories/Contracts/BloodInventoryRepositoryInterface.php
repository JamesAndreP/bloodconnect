<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BloodInventoryRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function deduct(array $data);
    public function showPerType(string $type);
}
