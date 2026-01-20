<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactPerson\StoreContactPersonRequest;
use App\Http\Requests\ContactPerson\UpdateContactPersonRequest;
use App\Services\ContactPersonService;
use Illuminate\Http\Request;

class ContactPersonController extends Controller
{
    public function __construct(protected ContactPersonService $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        return response()->json($this->service->paginate($perPage));
    }

    public function show(int $id)
    {
        return response()->json($this->service->findOrFail($id));
    }

    public function store(StoreContactPersonRequest $request)
    {
        $person = $this->service->create($request->validated());
        return response()->json($person, 201);
    }

    public function update(UpdateContactPersonRequest $request, int $id)
    {
        $person = $this->service->update($id, $request->validated());
        return response()->json($person);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json(['deleted' => true]);
    }
}
