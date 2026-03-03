<?php

namespace App\Observers;

use App\Models\Graphic;
use App\Models\Kassa;
use App\Models\Payment;
use App\Models\User;
use Goodoneuz\PayUz\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param  Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        $user = User::where('role','=',1)->first();
        $kassa = Kassa::where('is_click','=',1)->first();
        $graphic = Graphic::find($transaction->transactionable_id);

        if ($transaction->getOriginal('state') == 1 && $transaction->state == 2 ){
            $payment = new Payment();
            $payment->month_id = $graphic->month;
            $payment->amount = $transaction->amount;
            $payment->kitchen = $graphic->kitchen;
            $payment->bedroom = $graphic->bedroom;
            $payment->education = $graphic->education;
            $payment->comment = 'Click payment';
            $payment->user_id = $user->id;
            $payment->graphic_id = $graphic->id;
            $payment->student_id = $graphic->student_id;
            $payment->kassa_id = $kassa->id;
            $payment->transaction_id = $transaction->id;
            $payment->date = $transaction->updated_at;
        }

        if ($transaction->getOriginal('state') == 2 && $transaction->state == -2 ){
            $payment = Payment::where('transaction_id','=',$transaction->id);
            $payment->delete();
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
