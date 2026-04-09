<?php

namespace App\Repositories;

use App\Models\Hospital;
use App\Repositories\Contracts\HospitalRepositoryInterface;

class HospitalRepository implements HospitalRepositoryInterface
{
    public function create(array $data): Hospital
    {
        return Hospital::create($data);
    }

    public function update(array $data): bool
    {
        return Hospital::where('id', $data['hospital_id'])
            ->update([
                'name' => $data['name'],
                'location' => $data['location'],
            ]);
    }

    public function delete(int $id): int
    {
        return Hospital::where('id', $id)->delete();
    }

    public function getAll()
    {
        // eager load user since it's one-to-one
        return Hospital::with('user')->get();
    }

    public function findById(int $id)
    {
        return Hospital::with('user')->findOrFail($id);
    }

    public function findNearestHospital($userLat, $userLng)
    {
        return Hospital::selectRaw("
            *,
            (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(SUBSTRING_INDEX(SUBSTRING_INDEX(location, '|', -2), '|', 1))) *
                    cos(radians(SUBSTRING_INDEX(location, '|', -1)) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(SUBSTRING_INDEX(SUBSTRING_INDEX(location, '|', -2), '|', 1)))
                )
            ) AS distance
            ", [$userLat, $userLng, $userLat])
            ->orderBy('distance', 'asc')
            ->first();
    }
    public function findNearbyHospitals($userLat, $userLng, $userArea = null)
{
    $query = Hospital::selectRaw("
        *,
        (
            6371 * acos(
                cos(radians(?)) *
                cos(radians(SUBSTRING_INDEX(SUBSTRING_INDEX(location, '|', -2), '|', 1))) *
                cos(radians(SUBSTRING_INDEX(location, '|', -1)) - radians(?)) +
                sin(radians(?)) *
                sin(radians(SUBSTRING_INDEX(SUBSTRING_INDEX(location, '|', -2), '|', 1)))
            )
        ) AS distance
    ", [$userLat, $userLng, $userLat]);

    if ($userArea) {
        $sameAreaHospitals = (clone $query)
            ->whereRaw("LOWER(SUBSTRING_INDEX(location, '|', 1)) = ?", [strtolower($userArea)])
            ->orderBy('distance', 'asc')
            ->get();

        if ($sameAreaHospitals->count() > 0) {
            return $sameAreaHospitals;
        }
    }

    return $query
        ->having('distance', '<=', 3)
        ->orderBy('distance', 'asc')
        ->get();
}
}
