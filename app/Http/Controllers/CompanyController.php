<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        return response()->json($this->service->paginate($perPage));
    }

    public function show(int $id)
    {
        return response()->json($this->service->findOrFail($id));
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = $this->service->create($request->validated());
        return response()->json($company, 201);
    }

    public function update(UpdateCompanyRequest $request, int $id)
    {
        $company = $this->service->update($id, $request->validated());
        return response()->json($company);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json(['deleted' => true]);
    }
}
