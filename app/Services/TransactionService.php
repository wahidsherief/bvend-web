<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService extends BaseService
{
    protected $locker_machine_transaction;
    protected $machine_service;
    protected $transaction_locker;

    public function __construct(
        Transaction $transaction,
        MachineService $machine_service
    ) {
        $this->transaction = $transaction;
        $this->machine_service = $machine_service;
    }

    public function getAllTransactionsOfVendor($vendor_id, $paginate)
    {
        $transactions = $this->transaction->where(['vendor_id' => $vendor_id, 'status' => 'success'])->latest()->paginate($paginate);

        return $transactions;
    }

    // public function getSpecificTransactionOfVendor($vendor_id, $transaction_id)
    // {
    //     $transaction = Transaction::with(['lockers.refill.product.category', 'lockers.refill.product.brand', 'vendor'])
    //     ->where(['vendor_id' => $vendor_id, 'id' => $transaction_id])->first();

    //     // $transaction->machine = Machine::where($vendor_id, $transaction->machine_id);

    //     return $transaction;
    // }

    public function saveTransaction(array $attributes)
    {
        $transaction = $this->transaction->newInstance()->fill($attributes);

        $transaction->save();

        return $transaction;
    }
}
