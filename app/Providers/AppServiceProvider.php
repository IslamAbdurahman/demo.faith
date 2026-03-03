<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\Salary;
use App\Models\StudentGroup;
use App\Observers\PaymentObserver;
use App\Observers\SalaryObserver;
use App\Observers\StudentGroupObserver;
use App\Observers\TransactionObserver;
use Goodoneuz\PayUz\Models\Transaction;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Payment::observe(PaymentObserver::class);
        Salary::observe(SalaryObserver::class);
        StudentGroup::observe(StudentGroupObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
