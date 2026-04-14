<?php

namespace App\Services;

use App\Enums\InventoryEnum;
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

    public function showPerType($type)
    {
        $data = $this->repository->showPerType($type);
        return $data->map(function ($dat) {
            $dat->remarks = 'External';
            if ($dat->donationRequest) {
                $dat->remarks = 'Donation';
            } else if ($dat->bloodRequest && $dat->previous_quantity > $dat->current_quantity) {
                $dat->remarks = 'Donation to another Hospital';
            } else if ($dat->bloodRequest && $dat->previous_quantity < $dat->current_quantity) {
                $dat->remarks = 'Request from another Hospital';
            } else if ($dat->type == InventoryEnum::External->value) {
                if ($dat->previous_quantity < $dat->current_quantity) {
                    $dat->remarks = 'Add External';
                } else {
                    $dat->remarks = 'Deduct External';
                }
            }
            if ($dat->previous_quantity > $dat->current_quantity) {
                $dat->changed_quantity = '- ' . $dat->quantity;
            } else {
                $dat->changed_quantity = '+ ' . $dat->quantity;
            }
            $dat->created_at_modified = $dat->created_at
                ->timezone(config('app.timezone'))
                ->format('Y-m-d h:i A');
            return $dat;
        });
    }
}
