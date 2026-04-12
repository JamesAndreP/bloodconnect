<?php

namespace App\Repositories\Contracts;

interface DonationRequestRepositoryInterface
{
    public function all();
    public function allWithRelation();
    public function allWithRelationWithDeleted();
    public function allByDonor();
    public function allByHospital(int $hospital_id);
    public function allRescheduleByHospital(int $hospital_id);
    public function allApprovedByHospital(int $hospital_id);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function approve(int $id, array $data);
    public function confirm(int $id);
    public function reschedule(int $id, array $data);
    public function approveReschedule(int $id);
    public function declineReschedule(int $id);
    public function cancel(int $id);
    public function delete(int $id);
    public function findLatestActiveDonation();
    public function findLatestDonationRequest();
    public function findAllByDonor();
    public function findAllScheduledByDonor();
    public function getMonthlyAcceptedDataThisYearByHospital();
    public function getMonthlyDataThisYearByHospital();
}
