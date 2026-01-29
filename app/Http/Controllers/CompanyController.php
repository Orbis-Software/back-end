<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        return response()->json($this->service->paginate($perPage));
    }

    public function show()
    {
        $user = Auth::user();

        if (!$user || !$user->company) {
            abort(404, 'Company not found');
        }

        return new CompanyResource($user->company);
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = $this->service->create($request->validated());
        return (new CompanyResource($company))->response()->setStatusCode(201);
    }

public function update(UpdateCompanyRequest $request)
{
    $user = Auth::user();

    if (!$user || !$user->company) {
        abort(404, 'Company not found');
    }

    // 🔍 1. Log raw request payload
    Log::info('[Company Update] Raw request input', [
        'user_id' => $user->id,
        'input'   => $request->all(),
    ]);

    // 🔍 2. Log validated payload
    $validated = $request->validated();

    Log::info('[Company Update] Validated payload', [
        'user_id'   => $user->id,
        'validated' => $validated,
    ]);

    // 🔍 3. Log company BEFORE update
    Log::info('[Company Update] Before update', [
        'company_id' => $user->company->id,
        'company'    => $user->company->only(array_keys($validated)),
    ]);

    // ✅ Update
    $company = $this->service->update(
        $user->company->id,
        $validated
    );

    // 🔍 4. Log company AFTER update (fresh)
    $company->refresh();

    Log::info('[Company Update] After update', [
        'company_id' => $company->id,
        'company'    => $company->only(array_keys($validated)),
    ]);

    return new CompanyResource($company);
}

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json(['deleted' => true]);
    }
}
