<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\JobRevenueService;
use App\Http\Requests\StoreJobRevenueRequest;
use App\Http\Requests\UpdateJobRevenueRequest;
use App\Http\Resources\JobRevenueLineResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\JsonResponse;

class JobRevenueController extends Controller
{
    protected JobRevenueService $service;

    public function __construct(JobRevenueService $service)
    {
        $this->service = $service;
    }

    public function index(Job $job): ResourceCollection
    {
        return JobRevenueLineResource::collection(
            $this->service->listByJob($job)
        );
    }

    public function store(StoreJobRevenueRequest $request, Job $job): JobRevenueLineResource
    {
        $revenue = $this->service->createForJob($job, $request->validated());

        return new JobRevenueLineResource($revenue);
    }

    public function update(UpdateJobRevenueRequest $request, Job $job, int $id): JobRevenueLineResource
    {
        $revenue = $this->service->updateRevenue($id, $job, $request->validated());

        return new JobRevenueLineResource($revenue);
    }

    public function destroy(Job $job, int $id): JsonResponse
    {
        $this->service->deleteRevenue($id, $job);

        return response()->json(null, 204);
    }
}
