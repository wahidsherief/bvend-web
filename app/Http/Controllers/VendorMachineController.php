<?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\Machine;
// use App\Models\Refill;
// use App\Models\Vendor;
// use App\Models\MachineProduct;
// use Carbon\Carbon;
// use App\Services\TransactionService;

// class VendorMachineController extends Controller
// {
//     protected $transactionService;

//     public function __construct(TransactionService $transactionService)
//     {
//         $this->transactionService = $transactionService;
//     }

//     public function allMachines($vendorId)
//     {

//         $machines = $this->machinesByVendor($vendorId);

//         return $machines
//             ? successResponse('Machines fetched successfully.', $machines)
//             : errorResponse('Machines fetch failed.');
//     }

//     public function setProductPrice(Request $request)
//     {
//         $isPriceSet = MachineProduct::where([
//                 ['product_id', $request->product_id],
//                 ['machine_id', $request->machine_id]
//             ])->update(['price' => $request->price]);

//         return $isPriceSet
//                     ? successResponse('Price set successfully', $this->machinesByVendor($request->vendor_id))
//                     : errorResponse('Price set failed');
//     }


//     public function saveRefill(Request $request)
//     {
//         $refillData = [
//             'product_id' => $request->product_id,
//             'quantity' => $request->quantity,
//             'price' => $request->price,
//         ];

//         $isRefilled = Refill::where([
//             'machine_id' => $request->machineId,
//             'row_no' => $request->row_no,
//             'column_no' => $request->column_no
//         ])->update($refillData);

//         if(!$isRefilled) {
//             return errorResponse('Refill failed.');
//         }

//         $machines = $this->machinesByVendor($request->vendor_id);

//         return $machines
//             ? successResponse('Refilled successfully.', $machines)
//             : errorResponse('Refill failed.', $machines);
//     }

//     private function machinesByVendor($vendorId)
//     {

//         $machines = Machine::where('vendor_id', $vendorId)
//         ->with(['machineType', 'products.category', 'refills.product', 'transactions.products'])
//         ->get();

//         return $this->transactionService->allTransactionsByMachines($machines);
//     }
// }
