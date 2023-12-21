<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService extends BaseService
{
    public function transactionsByMachine($machine)
    {
        $transactionsGroupByDate = $machine->transactions->groupBy(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->updated_at)->format('Y-m-d');
        });

        $formattedTransactions = $this->formatTransactions($transactionsGroupByDate);

        unset($machine->transactions);

        $machine->transactions = $formattedTransactions;

        return $machine;
    }

    public function transactionsByMachines($machines)
    {
        $transactions = $machines->map(function ($machine) {
            return $this->transactionsByMachine($machine);
        });

        return $transactions;
    }

    private function formatTransactions($transactions)
    {
        $formattedTransactions = [];

        foreach ($transactions as $date => $transactionGroup) {
            $sumOfTotalAmounts = $transactionGroup->sum('total_amount');

            $formattedTransaction = $this->mapResponse($transactionGroup);

            $formattedTransactions[] = [
                'date' => readableDate($date),
                'data' => $formattedTransaction->all(),
                'total_amount' => $sumOfTotalAmounts,
            ];
        }

        return $formattedTransactions;
    }

    private function mapResponse($transaction)
    {
        return $transaction->map(function ($data) {
            return [
                'id' => $data->id,
                'machine_id' => $data->machine_id,
                'vendor_id' => $data->vendor_id,
                'bkash_merchant_number' => $data->bkash_merchant_number,
                'customer_number' => $data->customer_number,
                'invoice_no' => $data->invoice_no,
                'bkash_trx_id' => $data->bkash_trx_id,
                'total_amount' => $data->total_amount,
                'discount' => $data->discount,
                'payment_method_id' => $data->payment_method_id,
                'status' => $data->status,
                'sold_at' => \Carbon\Carbon::parse($data->updated_at)->format('h:i A'),
                'product' => $data->product
            ];
        });
    }


    // public function saveTransaction(array $attributes)
    // {
    //     $transaction = $this->transaction->newInstance()->fill($attributes);

    //     $transaction->save();

    //     return $transaction;
    // }

}
