<?php

namespace App\Observers;

use App\Models\Graphic;
use App\Models\Kassa;
use App\Models\Payment;
use App\Models\User;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function creating(Payment $payment)
    {
        $kassa = Kassa::find($payment->kassa_id);
        $kassa->balance = $kassa->balance + $payment->amount;
        $kassa->update();

        $graphic = Graphic::find($payment->graphic_id);
        $graphic->paid_amount = $graphic->paid_amount + $payment->amount;
        $graphic->remaining_amount = $graphic->remaining_amount - $payment->amount;
        $graphic->update();

        $teacher = User::find($payment->graphic->group->teacher_id);
        $teacher->balance = $teacher->balance + $payment->amount/100*$payment->graphic->group->percent;
        $teacher->update();

        $payment->teacher_amount = $payment->amount/100*$payment->graphic->group->percent;

    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function deleting(Payment $payment)
    {

        $kassa = Kassa::find($payment->getOriginal('kassa_id'));
        $kassa->balance = $kassa->balance-$payment->getOriginal('amount');
        $kassa->update();

        $graphic = Graphic::find($payment->getOriginal('graphic_id'));
        $graphic->paid_amount = $graphic->paid_amount - $payment->getOriginal('amount');
        $graphic->remaining_amount = $graphic->remaining_amount + $payment->getOriginal('amount');
        $graphic->update();

        $teacher = User::find($payment->graphic->group->teacher_id);
        $teacher->balance = $teacher->balance - $payment->getOriginal('teacher_amount');
        $teacher->update();

    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
