<?php

namespace App\Services;

use App\Repositories\Contracts\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CompanyService extends BaseService
{
    public function __construct(protected CompanyRepositoryInterface $companies) {}

    protected function repository(): CompanyRepositoryInterface
    {
        return $this->companies;
    }

    public function create(array $data): Model
    {
        // ✅ handle logo upload
        if (Arr::has($data, 'logo') && $data['logo'] instanceof UploadedFile) {
            $data['logo'] = $this->storeCompanyLogo($data['logo']);
        } else {
            // if logo key is present but null -> keep null
            $data['logo'] = $data['logo'] ?? null;
        }

        return parent::create($data);
    }

    public function update(int $id, array $data): Model
    {
        $company = $this->findOrFail($id);

        // ✅ if new logo uploaded, replace old
        if (Arr::has($data, 'logo') && $data['logo'] instanceof UploadedFile) {
            if (!empty($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }

            $data['logo'] = $this->storeCompanyLogo($data['logo']);
        } else {
            // if logo not included in request, don't touch it
            if (!Arr::has($data, 'logo')) {
                unset($data['logo']);
            }
        }

        return parent::update($id, $data);
    }

    protected function storeCompanyLogo(UploadedFile $file): string
    {
        // returns: company-logos/xxxxx.webp
        return $file->store('company-logos', 'public');
    }
}
