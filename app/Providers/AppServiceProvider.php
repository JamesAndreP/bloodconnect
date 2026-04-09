<?php

namespace App\Providers;

use App\Repositories\BloodRequestRepository;
use App\Repositories\Contracts\BloodRequestRepositoryInterface;
use App\Repositories\Contracts\HospitalRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\DonationRequestRepositoryInterface;
use App\Repositories\HospitalRepository;
use App\Repositories\UserRepository;
use App\Repositories\DonationRequestRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(HospitalRepositoryInterface::class, HospitalRepository::class);
        $this->app->bind(DonationRequestRepositoryInterface::class, DonationRequestRepository::class);
        $this->app->bind(BloodRequestRepositoryInterface::class, BloodRequestRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
