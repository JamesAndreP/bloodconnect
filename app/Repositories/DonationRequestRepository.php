<?php

namespace App\Repositories;

use App\Enums\DonationRequestScheduleStatusEnum;
use App\Enums\DonationRequestStatusEnum;
use App\Enums\InventoryEnum;
use App\Enums\InventoryStatusEnum;
use App\Models\DonationRequest;
use App\Models\DonationRequestSchedule;
use App\Models\Hospital;
use App\Models\Quantity;
use App\Models\User;
use App\Repositories\Contracts\DonationRequestRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationRequestRepository implements DonationRequestRepositoryInterface
{
    public function all()
    {
        return DonationRequest::all();
    }

    public function allWithRelation()
    {
        return DonationRequest::with(['user', 'hospital'])
            ->get();
    }

    public function allWithRelationWithDeleted()
    {
        return DonationRequest::with([
            'user' => function ($query) {
                $query->withTrashed();
            },
            'hospital' => function ($query) {
                $query->withTrashed();
            }
        ])->get();
    }

    public function allByDonor()
    {
        $user = Auth::user();
        return User::with(['donations' => function ($query) {
            $query->whereHas('hospital', function ($q) {
                $q->whereNull('deleted_at');
            })
                ->with(['hospital', 'latestActiveSchedule', 'latestRescheduleRequest', 'latestDeclinedRescheduleRequest'])
                ->orderBy('id', 'asc');
        }])
            ->where('id', $user->id)
            ->first();
    }

    public function allByHospital(int $hospital_id)
    {
        return DonationRequest::with(['user' => function ($query) {
            $query->orderBy('id', 'asc');
        }])
            ->where('hospital_id', $hospital_id)
            ->where('status', DonationRequestStatusEnum::Pending)
            ->get();
    }

    public function getMonthlyDataThisYearByHospital()
    {
        $user = Auth::user();
        $hospital = Hospital::where('user_id', $user->id)->first();

        $results = DonationRequest::select(
            DB::raw('MONTH(created_at) AS month'),
            DB::raw('COUNT(*) AS total')
        )
            ->whereYear('created_at', now()->year)
            ->where('hospital_id', $hospital->id)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Create an array of 12 months with 0 default
        $fullData = collect(range(1, 12))->map(function ($month) use ($results) {
            $match = $results->firstWhere('month', $month);

            return [
                'month' => $month,
                'total' => $match ? $match->total : 0,
            ];
        });

        return $fullData;
    }

    public function getMonthlyAcceptedDataThisYearByHospital()
    {
        $user = Auth::user();
        $hospital = Hospital::where('user_id', $user->id)->first();

        $results = DonationRequest::select(
            DB::raw('MONTH(created_at) AS month'),
            DB::raw('COUNT(*) AS total')
        )
            ->whereYear('created_at', now()->year)
            ->where('hospital_id', $hospital->id)
            ->whereHas('schedules', function ($query) {
                $query->where('status', DonationRequestScheduleStatusEnum::Active);
            })
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        // Create an array of 12 months with 0 default
        $fullData = collect(range(1, 12))->map(function ($month) use ($results) {
            $match = $results->firstWhere('month', $month);

            return [
                'month' => $month,
                'total' => $match ? $match->total : 0,
            ];
        });

        return $fullData;
    }

    public function allRescheduleByHospital(int $hospital_id)
    {
        return DonationRequest::with(['user' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'latestActiveSchedule', 'latestRescheduleRequest'])
            ->where('hospital_id', $hospital_id)
            ->where('status', DonationRequestStatusEnum::RescheduleRequest)
            ->get();
    }

    public function allApprovedByHospital(int $hospital_id)
    {
        return DonationRequest::with(['user' => function ($query) {
            $query->orderBy('id', 'asc');
        }])
            ->where('hospital_id', $hospital_id)
            ->where('status', DonationRequestStatusEnum::Approved)
            ->get();
    }

    public function find(int $id)
    {
        return DonationRequest::findOrFail($id);
    }

    public function create(array $data)
    {
        $user = Auth::user();
        $latestDonationRequest = DonationRequest::where('user_id', $data['user_id'])
            ->where('status', DonationRequestStatusEnum::Approved)
            ->latest()
            ->first();
        if ($latestDonationRequest) {
            if (strtoupper($user->gender) == 'MALE') {
                $allowDate = $latestDonationRequest->created_at->addMonths(4)->format('M d, Y');
                if ($latestDonationRequest->created_at->gt(now()->subMonths(4))) {
                    throw new \Exception(
                        "You can only request again after {$allowDate}."
                    );
                }
            } else {
                $allowDate = $latestDonationRequest->created_at->addMonths(3)->format('M d, Y');
                if ($latestDonationRequest->created_at->gt(now()->subMonths(3))) {
                    throw new \Exception(
                        "You can only request again after {$allowDate}."
                    );
                }
                $latestPendingRequest = DonationRequest::where('user_id', $data['user_id'])
                    ->where('status', DonationRequestStatusEnum::Pending)
                    ->latest()
                    ->first();

                if ($latestPendingRequest) {
                    throw new \Exception("You already have a pending donation request.");
                }
            }
        }
        $donationRequest = DonationRequest::create($data);
        return DonationRequest::with(['user', 'hospital', 'hospital.user'])->where('id', $donationRequest->id)->first();
    }

    public function update(int $id, array $data)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update($data);
        return $donationRequest;
    }

    public function approve(int $id, array $data)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Approved]);

        DonationRequestSchedule::where('donation_request_id', $donationRequest->id)
            ->update(['status' => DonationRequestScheduleStatusEnum::Inactive]);

        DonationRequestSchedule::create([
            'donation_request_id' => $donationRequest->id,
            'date' => $data['date'],
            'notes' => $data['notes'],
            'status' => DonationRequestScheduleStatusEnum::Active
        ]);

        return DonationRequest::with(['user', 'hospital', 'hospital.user', 'latestActiveSchedule'])
            ->where('id', $donationRequest->id)
            ->first();
    }

    public function confirm(int $id)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Confirmed]);

        $latestQuantity = Quantity::where('hospital_id', $donationRequest->hospital_id)
            ->where('blood_type', $donationRequest->blood_type)
            ->where('status', InventoryStatusEnum::Active)
            ->orderBy('id', 'desc')
            ->first();

        if ($latestQuantity) {
            $latestQuantity->update(['status' => InventoryStatusEnum::Inactive]);
        }

        Quantity::create([
            'hospital_id' => $donationRequest->hospital_id,
            'donation_request_id' => $donationRequest->id,
            'quantity' => 1,
            'previous_quantity' => $latestQuantity ? $latestQuantity->current_quantity : 0,
            'current_quantity' => ($latestQuantity ? $latestQuantity->current_quantity : 0) + 1,
            'type' => InventoryEnum::System,
            'blood_type' => $donationRequest->blood_type,
            'status' => InventoryStatusEnum::Active
        ]);

        return DonationRequest::with(['user', 'hospital', 'hospital.user', 'latestActiveSchedule'])
            ->where('id', $donationRequest->id)
            ->first();
    }

    public function reschedule(int $id, array $data)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::RescheduleRequest]);
        // DonationRequestSchedule::where('donation_request_id', $donationRequest->id)
        //     ->update(['status' => DonationRequestScheduleStatusEnum::Inactive]);
        DonationRequestSchedule::create([
            'donation_request_id' => $donationRequest->id,
            'date' => $data['date'],
            'notes' => $data['notes'],
            'status' => DonationRequestScheduleStatusEnum::Pending
        ]);
        // return $donationRequest;
        return User::with(['donations' => function ($query) use ($donationRequest) {
            $query->with(['hospital', 'hospital.user', 'latestActiveSchedule', 'latestRescheduleRequest', 'latestDeclinedRescheduleRequest'])
                ->where('id', $donationRequest->id);
        }])->find($donationRequest->user_id);
    }

    public function approveReschedule(int $id)
    {
        $donationRequestSchedule = DonationRequestSchedule::findOrFail($id);
        DonationRequestSchedule::where('donation_request_id', $donationRequestSchedule->donation_request_id)
            ->update(['status' => DonationRequestScheduleStatusEnum::Inactive]);
        $donationRequestSchedule->update(['status' => DonationRequestScheduleStatusEnum::Active]);
        $donationRequest = DonationRequest::findOrFail($donationRequestSchedule->donation_request_id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Approved]);
        return User::with(['donations' => function ($query) use ($donationRequest) {
            $query->with(['hospital', 'hospital.user', 'latestActiveSchedule', 'latestRescheduleRequest', 'latestDeclinedRescheduleRequest'])
                ->where('id', $donationRequest->id);
        }])->find($donationRequest->user_id);
    }

    public function declineReschedule(int $id)
    {
        $donationRequestSchedule = DonationRequestSchedule::findOrFail($id);
        $donationRequestSchedule->update(['status' => DonationRequestScheduleStatusEnum::Declined]);
        $donationRequest = DonationRequest::findOrFail($donationRequestSchedule->donation_request_id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Approved]);
        return $donationRequest;
    }

    public function cancel(int $id)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        $donationRequest->update(['status' => DonationRequestStatusEnum::Cancelled]);
        return $donationRequest;
    }

    public function delete(int $id)
    {
        return DonationRequest::destroy($id);
    }

    public function findLatestActiveDonation()
    {
        $user = Auth::user();
        return DonationRequest::with([
            'schedules' => function ($query) {
                $query->where('status', DonationRequestScheduleStatusEnum::Active);
            },
            'hospital'
        ])
            ->where('user_id', $user->id)
            ->whereHas('schedules', function ($query) {
                $query->where('status', DonationRequestScheduleStatusEnum::Active);
            })
            ->latest('id')
            ->first();
    }

    public function findLatestDonationRequest()
    {
        $user = Auth::user();
        return DonationRequest::with(['schedules' => function ($query) {
            $query->orderBy('date', 'desc')->first();
        }, 'hospital'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function findAllByDonor()
    {
        $user = Auth::user();
        return DonationRequest::where('user_id', $user->id)->get();
    }

    public function findAllScheduledByDonor()
    {
        $user = Auth::user();
        return DonationRequest::where('user_id', $user->id)->whereHas('schedules')->get();
    }
}
