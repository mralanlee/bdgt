<?php

namespace App\Models;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = [
        'date_opened',
        'name',
        'balance',
        'interest',
        'interest_period',
        'user_id',
    ];

    protected $casts = [
        'date_opened' => 'date',
    ];

    public function getRunningBalanceAttribute()
    {
        $runningBalance = 0;
        foreach ($this->transactions()->get() as $transaction) {
            if ($transaction->inflow) {
                $runningBalance += $transaction->amount;
            } else {
                $runningBalance -= $transaction->amount;
            }
        }

        return $runningBalance;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
