<?php

namespace App\Http\Requests\Admin\Person;

use App\Http\Requests\Admin\AdminRequest;
use App\Models\Permission;

class GetPersonRequest extends AdminRequest
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
