<?php

namespace App\Services;

use App\Enums\DonationRequestStatusEnum;
use App\Mail\ApproveRequestAdminMail;
use App\Mail\ApproveRequestMail;
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

class DonationRequestService
{
    protected $repository;
    protected $userRepository;
    protected $hospitalRepository;

    public function __construct(
        DonationRequestRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        HospitalRepositoryInterface $hospitalRepository,
    ) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->hospitalRepository = $hospitalRepository;
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getAllWithRelation()
    {
        return $this->repository->allWithRelation();
    }

    public function getAllWithRelationWithDeleted()
    {
        return $this->repository->allWithRelationWithDeleted();
    }

    public function getAllByDonor()
    {
        return $this->repository->allByDonor();
    }

    public function getMonthlyDataThisYearByHospital()
    {
        return $this->repository->getMonthlyDataThisYearByHospital();
    }

    public function getMonthlyAcceptedDataThisYearByHospital()
    {
        return $this->repository->getMonthlyAcceptedDataThisYearByHospital();
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
        return $this->repository->allByHospital($hospital->id);
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
        return $this->repository->allRescheduleByHospital($hospital->id);
    }

    public function getAllApprovedByHospital()
    {
        $user = Auth::user();
        if (!$user || $user->role->value !== 'hospital') {
            abort(403, 'Forbidden.');
        }
        $hospital = Hospital::where('user_id', $user->id)->first();
        if (!$hospital) {
            abort(403, 'Forbidden.');
        }
        return $this->repository->allApprovedByHospital($hospital->id);
    }

    public function getById(int $id)
    {
        return $this->repository->find($id);
    }

    public function create($requestData = [])
    {
        $data = [];
        $user = Auth::user();

        $location = explode('|', $user->location);

        // 👉 If user selected hospital, use it
        if (isset($requestData['hospital_id']) && $requestData['hospital_id']) {
            $data['hospital_id'] = $requestData['hospital_id'];
        } else {
            // 👉 fallback to nearest hospital (original logic)
            $nearestHospital = $this->hospitalRepository->findNearestHospital($location[1], $location[2]);
            $data['hospital_id'] = $nearestHospital->id;
        }

        $data['user_id'] = $user->id;
        $data['date'] = now();
        $data['status'] = DonationRequestStatusEnum::Pending;
        $data['blood_type'] = $user->blood_type;

        $donationRequest = $this->repository->create($data);

        Mail::to($donationRequest->user->email)->queue(new DonationRequestMail($donationRequest));
        Mail::to($donationRequest->hospital->user->email)->queue(new DonationRequestAdminMail($donationRequest));

        return $donationRequest;
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function approve(int $id, array $data)
    {
        $donationRequest = $this->repository->approve($id, $data);

        Mail::to($donationRequest->user->email)
            ->send(new ApproveRequestMail($donationRequest));

        Mail::to($donationRequest->hospital->user->email)
            ->send(new ApproveRequestAdminMail($donationRequest));

        return $donationRequest;
    }

    public function confirm(int $id)
    {
        $donationRequest = $this->repository->confirm($id);

        // Mail::to($donationRequest->user->email)
        //     ->send(new ApproveRequestMail($donationRequest));

        // Mail::to($donationRequest->hospital->user->email)
        //     ->send(new ApproveRequestAdminMail($donationRequest));

        return $donationRequest;
    }

    public function reschedule(int $id, array $data)
    {
        $donationRequest = $this->repository->reschedule($id, $data);
        Mail::to($donationRequest->email)->queue(new RescheduleRequestMail($donationRequest));
        Mail::to($donationRequest->donations[0]->hospital->user->email)->queue(new RescheduleRequestAdminMail($donationRequest));
        return $donationRequest;
    }

    public function approveReschedule(int $id)
    {
        $donationRequest = $this->repository->approveReschedule($id);
        Mail::to($donationRequest->email)->queue(new ApproveRequestMail($donationRequest));
        Mail::to($donationRequest->donations[0]->hospital->user->email)->queue(new ApproveRequestAdminMail($donationRequest));
        return $donationRequest;
    }

    public function declineReschedule(int $id)
    {
        return $this->repository->declineReschedule($id);
    }

    public function cancel(int $id)
    {
        return $this->repository->cancel($id);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
