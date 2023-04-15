<?php

namespace App\Http\Requests\Admin\Organization;

use App\Http\Requests\Admin\AdminRequest;
use App\Models\Permission;

class GetOrganizationRequest extends AdminRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
