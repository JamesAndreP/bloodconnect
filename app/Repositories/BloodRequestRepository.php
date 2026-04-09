<?php

namespace App\Repositories;

use App\Enums\BloodRequestStatusEnum;
use App\Mail\BloodRequestMail;
use App\Mail\BloodRequestOwnerMail;
use App\Models\BloodRequest;
use App\Mail\BloodRequestFulfilledMail;
use App\Mail\BloodRequestFulfilledOwnerMail;
use App\Models\DonationRequest;
use App\Models\Hospital;
use App\Repositories\Contracts\BloodRequestRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BloodRequestRepository implements BloodRequestRepositoryInterface
{
    public function all()
    {
        return BloodRequest::whereHas('hospital', function ($q) {
            $q->whereNull('deleted_at');
        })
            ->with(['hospital' => function ($query) {
                $query->with('user');
            }])
            ->with(['confirmedBy'])
            ->get();
    }

    public function allByHospital()
    {
        $user = Auth::user();
        $hospital = Hospital::where('user_id', $user->id)->first();
        return BloodRequest::with(['hospital' => function ($query) {
            $query->with(['user']);
        }])
            ->where('hospital_id', $hospital->id)
            ->get();
    }

    public function find(int $id)
    {
        return BloodRequest::findOrFail($id);
    }

    public function create(array $data)
    {
        $user = Auth::user();
        $hospital = Hospital::where('user_id', $user->id)->first();
        $data['hospital_id'] = $hospital->id;
        $data['status'] = BloodRequestStatusEnum::Pending;
        $data['request_date'] = Carbon::now();
        $create = BloodRequest::create($data);
        $bloodRequest = BloodRequest::with(['hospital', 'hospital.user'])->where('id', $create->id)->first();
        $hospitals = Hospital::with(['user'])->where('id', '<>', $hospital->id)->get();
        Mail::to($bloodRequest->hospital->user->email)->queue(new BloodRequestOwnerMail($bloodRequest));
        foreach ($hospitals as $hos) {
            Mail::to($hos->user->email)->queue(new BloodRequestMail($bloodRequest, $hos));
        }
        return $bloodRequest;
    }

    public function fulfill(int $id)
{
    $user = Auth::user();
    $hospital = Hospital::where('user_id', $user->id)->first();

    $bloodRequest = BloodRequest::findOrFail($id);

    $bloodRequest->update([
        'status' => BloodRequestStatusEnum::Fulfilled,
        'confirmed_by' => $hospital->id,
    ]);

    // 👉 ADD THIS LINE (reload with relation)
    $bloodRequest->load(['hospital', 'hospital.user', 'confirmedBy']);

    // 👉 ADD EMAIL (owner)
    if (!empty($bloodRequest->hospital->user->email)) {
        Mail::to($bloodRequest->hospital->user->email)
            ->queue(new \App\Mail\BloodRequestFulfilledOwnerMail($bloodRequest));
    }

    // 👉 ADD EMAIL (fulfilling hospital)
    if (!empty($hospital->user->email)) {
        Mail::to($hospital->user->email)
            ->queue(new \App\Mail\BloodRequestFulfilledMail($bloodRequest));
    }

    return $bloodRequest;
}

    public function update(int $id, array $data)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->update($data);
        return $bloodRequest;
    }

    public function delete(int $id)
    {
        return BloodRequest::destroy($id);
    }
}
