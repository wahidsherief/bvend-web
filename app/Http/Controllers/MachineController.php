<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\MachineProduct;
use App\Models\Refill;
use App\Services\MachineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\SaveMachineRequest;
use App\Http\Requests\Admin\UpdateMachineRequest;

class MachineController extends Controller
{
    protected $service;

    public const ofAdmin = ['machineType', 'vendor', 'products.category', 'transactions.product'];

    public const ofVendor = ['machineType','products.category', 'transactions.product', 'refills.product'];


    public function __construct(MachineService $service)
    {
        $this->service = $service;
    }

    public function getMachines()
    {
        $this->service->withRelations(self::ofAdmin);

        $machines = $this->service->all();

        return $machines ?
            successResponse('Machines fetched successfully', $machines)
            : errorResponse('Fetching machine failed');
    }

    public function createMachine(SaveMachineRequest $request)
    {
        $this->service->withRelations(self::ofAdmin);

        $machines = $this->service->save($request);

        return $machines ?
            successResponse('Machine created successfully', $machines)
            : errorResponse('Machine create falied');
    }

    public function updateMachine(UpdateMachineRequest $request, $id)
    {
        $this->service->withRelations(self::ofAdmin);

        $machines = $this->service->update($request, $id);

        return $machines ?
            successResponse('Machine updated successfully', $machines)
            : errorResponse('Machine update failed');
    }

    public function deleteMachine($id)
    {
        $this->service->withRelations(self::ofAdmin);

        $machines = $this->service->delete($id);

        return $machines ?
            successResponse('Machine deleted successfully', $machines)
            : errorResponse('Machine delete failed');
    }

    public function getVendorMachines($vendorId)
    {
        $machines = $this->vendorMachines($vendorId);

        return $machines ?
            successResponse('Machines fetched successfully', $machines)
            : errorResponse('Machine fetch failed');
    }

    public function setMachineProductPrice(Request $request)
    {
        $isPriceSet = MachineProduct::where([
                ['product_id', $request->product_id],
                ['machine_id', $request->machine_id]
            ])->update(['price' => $request->price]);

        return $isPriceSet
                    ? successResponse('Price set successfully', $this->vendorMachines($request->vendor_id))
                    : errorResponse('Price set failed');
    }

    public function saveMachineRefill(Request $request)
    {
        $refillData = [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ];

        $isRefilled = Refill::where([
            'machine_id' => $request->machineId,
            'row_no' => $request->row_no,
            'column_no' => $request->column_no
        ])->update($refillData);

        if(!$isRefilled) {
            return errorResponse('Refill failed.');
        }

        $machines = $this->vendorMachines($request->vendor_id);

        return $machines
            ? successResponse('Refilled successfully.', $machines)
            : errorResponse('Refill failed.', $machines);
    }

    private function vendorMachines($vendorId)
    {
        $ofVendor = ['vendor_id' => $vendorId];

        $this->service->withRelations(self::ofVendor)->withConditions($ofVendor);

        return $this->service->all();
    }
}
