<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct() {}

    public function all()
    {
        $transactions = Transaction::all();

        return $transactions
            ? successResponse('Transaction fetched successfully.', $transactions)
            : errorResponse('Transaction fetch failed.');
    }

    public function getByVendor($id)
    {
        $transactions = Transaction::where('machine_id', $id)
            ->orderBy('updated_at')
            ->get()
            ->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->updated_at)->format('Y-m-d');
            });

        return $transactions
            ? successResponse('Transaction fetched successfully.', $transactions)
            : errorResponse('Transaction fetch failed.');
    }

}
