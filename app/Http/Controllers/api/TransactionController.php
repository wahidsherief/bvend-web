<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\BaseService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $service;
    protected $transaction;

    public function __construct(BaseService $service, Transaction $transaction)
    {
        // $this->middleware('auth:admin');
        $this->service = $service;
        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransactionResource::collection($this->transaction->all())->response(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stored = $this->transaction->create($request->all());
        return response(new TransactionResource($stored), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->transaction->find($id)->delete();
        // return response('success', 204);
    }
}
