<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransportJob\StoreTransportJobRequest;
use App\Http\Requests\TransportJob\UpdateTransportJobRequest;
use App\Services\TransportJobService;
use Illuminate\Http\Request;

class TransportJobController extends Controller
{
    public function __construct(protected TransportJobService $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        return response()->json($this->service->paginate($perPage));
    }

    public function show(int $id)
    {
        return response()->json($this->service->findOrFail($id));
    }

    public function store(StoreTransportJobRequest $request)
    {
        $job = $this->service->create($request->validated());
        return response()->json($job, 201);
    }

    public function update(UpdateTransportJobRequest $request, int $id)
    {
        $job = $this->service->update($id, $request->validated());
        return response()->json($job);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json(['deleted' => true]);
    }
}
