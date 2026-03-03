<?php

namespace App\Observers;

use App\Models\Kassa;
use App\Models\Salary;
use App\Models\User;

class SalaryObserver
{
    /**
     * Handle the Salary "created" event.
     *
     * @param  \App\Models\Salary  $salary
     * @return void
     */
    public function creating(Salary $salary)
    {
        $kassa = Kassa::find($salary->kassa_id);
        $kassa->balance = $kassa->balance - $salary->amount;
        $kassa->update();

        $user = User::find($salary->worker_id);
        $user->balance = $user->balance - $salary->amount;
        $user->update();
    }

    /**
     * Handle the Salary "updated" event.
     *
     * @param  \App\Models\Salary  $salary
     * @return void
     */
    public function updated(Salary $salary)
    {
        //
    }

    /**
     * Handle the Salary "deleted" event.
     *
     * @param  \App\Models\Salary  $salary
     * @return void
     */
    public function deleting(Salary $salary)
    {
        $kassa = Kassa::find($salary->getOriginal('kassa_id'));
        $kassa->balance = $kassa->balance + $salary->getOriginal('balance');
        $kassa->update();

        $user = User::find($salary->getOriginal('worker_id'));
        $user->balance = $user->balance + $salary->getOriginal('amount');
        $user->update();

    }

    /**
     * Handle the Salary "restored" event.
     *
     * @param  \App\Models\Salary  $salary
     * @return void
     */
    public function restored(Salary $salary)
    {
        //
    }

    /**
     * Handle the Salary "force deleted" event.
     *
     * @param  \App\Models\Salary  $salary
     * @return void
     */
    public function forceDeleted(Salary $salary)
    {
        //
    }
}
