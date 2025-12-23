<?php

namespace App\Http\Controllers;

use App\Services\ClientService;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientController extends Controller
{
    protected ClientService $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index(): ResourceCollection
    {
        $clients = $this->service->paginate();

        return ClientResource::collection($clients);
    }

    public function show(int $id): ClientResource
    {
        $client = $this->service->findOrFail($id);

        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $client = $this->service->create($request->validated());

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateClientRequest $request, int $id): ClientResource
    {
        $client = $this->service->update($id, $request->validated());

        return new ClientResource($client);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(null, 204);
    }

    public function byUser(int $userId): ClientResource
    {
        $client = $this->service->getByUser($userId);

        return new ClientResource($client);
    }
}
