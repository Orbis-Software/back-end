<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(protected ContactService $service) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);

        $filters = [

            'contact_type' => $request->query('contact_type'),
            'status'       => $request->query('status'),
        ];

        return response()->json($this->service->paginateFiltered($filters, $perPage));
    }

    public function show(int $id)
    {
        return response()->json($this->service->findOrFail($id));
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        $data['company_id'] = $request->user()->company_id;

        $contact = $this->service->create($data);
        return response()->json($contact, 201);
    }


    public function update(UpdateContactRequest $request, int $id)
    {
        $contact = $this->service->update($id, $request->validated());
        return response()->json($contact);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return response()->json(['deleted' => true]);
    }
}
