<?php

namespace App\Smartbnb;

use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Listen to the Transatcion created event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        if($transaction->deposit == true)
        {
            // increment the user deposit iteration
            $transaction->user()->increment('deposit_iteration');

            // increase the user total amount with the transaction amount
            $increasedAmount = $transaction->user->amount + $transaction->amount;
            $transaction->user()->update([ 'amount' => $increasedAmount ]);

            // if this is the third iteration, add the bonus percentage
            if($transaction->user->deposit_iteration == 3)
            {
                // calculate the new amount
                $amount = $transaction->amount;
                $percent = $transaction->user->bonus_percent;
                $bonus = ($amount * $percent) / 100;
                $total = $amount + $bonus;

                // update the transaction with the bonus added
                $transaction->update(['amount' => $total]);

                // update the user with the new amount and the resetted iteration
                $transaction->user()->update([
                    'deposit_iteration' => 0,
                    'amount'    => ($increasedAmount + $bonus)
                ]);
            }
        }
        else
        {
            // decrease the user total amount with the transaction amount
            $decreasedAmount = $transaction->user->amount - $transaction->amount;
            $transaction->user()->update([ 'amount' => $decreasedAmount ]);
        }
    }
}