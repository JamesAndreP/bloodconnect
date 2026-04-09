<?php

namespace App\Services;

use App\Enums\DonationRequestStatusEnum;
use App\Mail\DonationRequestAdminMail;
use App\Mail\DonationRequestMail;
use App\Mail\RescheduleRequestAdminMail;
use App\Mail\RescheduleRequestMail;
use App\Models\Hospital;
use App\Repositories\Contracts\DonationRequestRepositoryInterface;
use App\Repositories\Contracts\HospitalRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DashboardService
{
    protected $donationRequestRepository;
    protected $userRepository;
    protected $hospitalRepository;

    public function __construct(
        DonationRequestRepositoryInterface $donationRequestRepository,
        UserRepositoryInterface $userRepository,
        HospitalRepositoryInterface $hospitalRepository,
    ) {
        $this->donationRequestRepository = $donationRequestRepository;
        $this->userRepository = $userRepository;
        $this->hospitalRepository = $hospitalRepository;
    }

    public function getAll()
    {
        return $this->donationRequestRepository->all();
    }

    public function getAllByDonor()
    {
        return $this->donationRequestRepository->allByDonor();
    }

    public function getAllByHospital()
    {
        $user = Auth::user();
        if (!$user || $user->role->value !== 'hospital') {
            abort(403, 'Forbidden.');
        }
        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            abort(403, 'Forbidden.');
        }
        return $this->donationRequestRepository->allByHospital($hospital->id);
    }

    public function getAllRescheduleByHospital()
    {
        $user = Auth::user();
        if (!$user || $user->role->value !== 'hospital') {
            abort(403, 'Forbidden.');
        }
        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            abort(403, 'Forbidden.');
        }
        return $this->donationRequestRepository->allRescheduleByHospital($hospital->id);
    }

    public function getById(int $id)
    {
        return $this->donationRequestRepository->find($id);
    }

    public function create()
    {
        $data = [];
        $user = Auth::user();
        $location = explode('|', $user->location);
        $nearestHospital = $this->hospitalRepository->findNearestHospital($location[1], $location[2]);
        $data['user_id'] = $user->id;
        $data['hospital_id'] = $nearestHospital->id;
        $data['date'] = now();
        $data['status'] = DonationRequestStatusEnum::Pending;
        $donationRequest = $this->donationRequestRepository->create($data);
        Mail::to($donationRequest->user->email)->queue(new DonationRequestMail($donationRequest));
        Mail::to($donationRequest->user->email)->queue(new DonationRequestAdminMail($donationRequest));
        return $donationRequest;
    }

    public function update(int $id, array $data)
    {
        return $this->donationRequestRepository->update($id, $data);
    }

    public function approve(int $id, array $data)
    {
        return $this->donationRequestRepository->approve($id, $data);
    }

    public function reschedule(int $id, array $data)
    {
        $donationRequest = $this->donationRequestRepository->reschedule($id, $data);
        Mail::to($donationRequest->email)->queue(new RescheduleRequestMail($donationRequest));
        Mail::to($donationRequest->donations[0]->hospital->user->email)->queue(new RescheduleRequestAdminMail($donationRequest));
        return $donationRequest;
    }

    public function approveReschedule(int $id)
    {
        return $this->donationRequestRepository->approveReschedule($id);
    }

    public function declineReschedule(int $id)
    {
        return $this->donationRequestRepository->declineReschedule($id);
    }

    public function cancel(int $id)
    {
        return $this->donationRequestRepository->cancel($id);
    }

    public function delete(int $id)
    {
        return $this->donationRequestRepository->delete($id);
    }

    public function findLatestActiveDonation()
    {
        return $this->donationRequestRepository->findLatestActiveDonation();
    }

    public function findLatestDonationRequest()
    {
        return $this->donationRequestRepository->findLatestDonationRequest();
    }

    public function findAllByDonor()
    {
        return $this->donationRequestRepository->findAllByDonor();
    }

    public function findAllScheduledByDonor()
    {
        return $this->donationRequestRepository->findAllScheduledByDonor();
    }
}
