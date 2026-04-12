<?php

namespace App\Repositories;

use App\Enums\BloodRequestStatusEnum;
use App\Enums\InventoryEnum;
use App\Enums\InventoryStatusEnum;
use App\Mail\BloodRequestMail;
use App\Mail\BloodRequestOwnerMail;
use App\Models\BloodRequest;
use App\Mail\BloodRequestFulfilledMail;
use App\Mail\BloodRequestFulfilledOwnerMail;
use App\Models\DonationRequest;
use App\Models\Hospital;
use App\Models\Quantity;
use App\Repositories\Contracts\BloodInventoryRepositoryInterface;
use App\Repositories\Contracts\BloodRequestRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


class BloodInventoryRepository implements BloodInventoryRepositoryInterface
{
    public function all()
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            return [];
        }

        return Quantity::select(
            'blood_type',
            'current_quantity'
        )
            ->where('hospital_id', $hospital->id)
            ->where('status', InventoryStatusEnum::Active)
            ->get();
    }

    public function create(array $data)
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            return [];
        }

        $latestQuantity = Quantity::where('hospital_id', $hospital->id)
            ->where('blood_type', $data['blood_type'])
            ->where('status', InventoryStatusEnum::Active)
            ->orderBy('id', 'desc')
            ->first();

        if ($latestQuantity) {
            $latestQuantity->update(['status' => InventoryStatusEnum::Inactive]);
        }

        $data['hospital_id'] = $hospital->id;
        $data['previous_quantity'] = $latestQuantity ? $latestQuantity->current_quantity : 0;
        $data['current_quantity'] = ($latestQuantity ? $latestQuantity->current_quantity : 0) + $data['quantity'];
        $data['type'] = InventoryEnum::External;
        $data['status'] = InventoryStatusEnum::Active;
        return Quantity::create($data);
        // Mail::to($bloodRequest->hospital->user->email)->queue(new BloodRequestOwnerMail($bloodRequest));
        // foreach ($hospitals as $hos) {
        //     Mail::to($hos->user->email)->queue(new BloodRequestMail($bloodRequest, $hos));
        // }
    }

    public function deduct(array $data)
    {
        $user = Auth::user();
        if (!$user) {
            return [];
        }

        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            return [];
        }

        $latestQuantity = Quantity::where('hospital_id', $hospital->id)
            ->where('blood_type', $data['blood_type'])
            ->where('status', InventoryStatusEnum::Active)
            ->orderBy('id', 'desc')
            ->first();

        if (!$latestQuantity) {
            throw new \Exception("You don't have enough supply for this type.");
        }

        if ($latestQuantity->current_quantity < $data['quantity']) {
            throw new \Exception("You don't have enough supply for this type.");
        }

        $latestQuantity->update(['status' => InventoryStatusEnum::Inactive]);

        $data['hospital_id'] = $hospital->id;
        $data['previous_quantity'] = $latestQuantity->current_quantity;
        $data['current_quantity'] = $latestQuantity->current_quantity - $data['quantity'];
        $data['type'] = InventoryEnum::External;
        $data['status'] = InventoryStatusEnum::Active;
        return Quantity::create($data);
        // Mail::to($bloodRequest->hospital->user->email)->queue(new BloodRequestOwnerMail($bloodRequest));
        // foreach ($hospitals as $hos) {
        //     Mail::to($hos->user->email)->queue(new BloodRequestMail($bloodRequest, $hos));
        // }
    }
}
