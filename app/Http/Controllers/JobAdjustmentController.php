<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\JobAdjustmentService;
use App\Http\Requests\StoreJobAdjustmentRequest;
use App\Http\Resources\JobAdjustmentLineResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobAdjustmentController extends Controller
{
    protected JobAdjustmentService $service;

    public function __construct(JobAdjustmentService $service)
    {
        $this->service = $service;
    }

    public function index(Job $job): ResourceCollection
    {
        return JobAdjustmentLineResource::collection(
            $this->service->listByJob($job)
        );
    }

    public function store(StoreJobAdjustmentRequest $request, Job $job): JobAdjustmentLineResource
    {
        $adjustment = $this->service->createForJob($job, $request->validated());

        return new JobAdjustmentLineResource($adjustment);
    }
}
