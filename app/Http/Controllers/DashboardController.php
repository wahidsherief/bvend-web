<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function getAdminDashboard()
    {
        $result = $this->getDashboardData(null); // Passing null for admin, no vendor ID needed

        return $result ?
            successResponse('Admin dashboard fetched successfully', $result)
            : errorResponse('Fetching admin dashboard failed');
    }

    public function getVendorDashboard($vendorId)
    {
        $result = $this->getDashboardData($vendorId); // Passing vendor ID for vendor

        return $result ?
            successResponse('Vendor dashboard fetched successfully', $result)
            : errorResponse('Fetching vendor dashboard failed');
    }


    private function getDashboardData($vendorId)
    {
        $transactionsQuery = Transaction::join('machines', 'transactions.machine_id', '=', 'machines.id')
            ->selectRaw('
                transactions.machine_id,
                machines.id as machine_id,
                machines.machine_code, 
                machines.location, 
                SUM(CASE WHEN transactions.status = "Completed" AND DATE(transactions.created_at) = CURDATE() THEN transactions.total_amount ELSE 0 END) as today_total_amount,
                COUNT(CASE WHEN transactions.status = "Completed" AND DATE(transactions.created_at) = CURDATE() THEN 1 END) as today_total_sales,
                SUM(CASE WHEN transactions.status = "Completed" THEN transactions.total_amount ELSE 0 END) as total_amount,
                COUNT(CASE WHEN transactions.status = "Completed" THEN 1 END) as total_sales
            ')
            ->groupBy('transactions.machine_id', 'machines.id', 'machines.machine_code', 'machines.location');

        if ($vendorId !== null) {
            $transactionsQuery->where('machines.vendor_id', $vendorId);
        }

        $machineSales = $transactionsQuery->get();

        $todayMachineSales = [];
        $key = 0;
        foreach ($machineSales as $machineSale) {
            $todayMachineSales[$key] = [
                'machine_id' => $machineSale->machine_id,
                'machine_code' => $machineSale->machine_code,
                'location' => $machineSale->location,
                'today_total_amount' => $machineSale->today_total_amount,
                'today_total_sales' => $machineSale->today_total_sales,
            ];
            $key++;
        }


        $allMachineSales = [];
        $index = 0;
        foreach ($machineSales as $machineSale) {
            $allMachineSales[$index] = [
                'machine_id' => $machineSale->machine_id,
                'machine_code' => $machineSale->machine_code,
                'location' => $machineSale->location,
                'total_amount' => $machineSale->total_amount,
                'total_sales' => $machineSale->total_sales,
            ];
            $index++;
        }

        return [
            [
                'today_total_amount' => $machineSales->sum('today_total_amount'),
                'today_total_sales' => $machineSales->sum('today_total_sales'),
                'today_machine_sales' => $todayMachineSales,
                'total_amount' => $machineSales->sum('total_amount'),
                'total_sales' => $machineSales->sum('total_sales'),
                'machine_sales' => $allMachineSales,
            ]
        ];
    }

}
