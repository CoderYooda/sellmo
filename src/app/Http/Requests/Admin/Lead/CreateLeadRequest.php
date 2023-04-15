<?php

namespace App\Http\Requests\Admin\Lead;

use App\Http\Requests\Admin\AdminRequest;

class CreateLeadRequest extends AdminRequest
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
        return [
            'title' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:24'],
            'description' => ['required', 'string', 'regex:/^[a-zA-ZА-Яа-я0-9 ]+$/u', 'max:255'],
            'amount' => ['integer'],
            'lost_reason' => ['string', 'nullable'],
            'lead_source_id' => ['required', 'exists:lead_sources,id'],
            'person_id' => ['integer', 'nullable', 'exists:persons,id'],
            'person_full_name' => ['string', 'required_if:person_id,null'],
            'manager_id' => ['required', 'exists:persons,id'],
            'organization_id' => ['integer', 'nullable', 'exists:organizations,id'],
            'organization_name' => ['string', 'max:24', 'required_if:organization_id,null'],
            'lead_type_id' => ['required', 'exists:lead_types,id'],
            'pipeline_stage_id' => ['required', 'exists:pipeline_stages,id'],
        ];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->validated()['title'];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->validated()['description'];
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->validated()['amount'];
    }

    /**
     * @return ?string
     */
    public function getLostReason(): ?string
    {
        return $this->validated()['lost_reason'];
    }

    /**
     * @return int
     */
    public function getLeadSourceId(): int
    {
        return $this->validated()['lead_source_id'];
    }

    /**
     * @return ?int
     */
    public function getPersonId(): ?int
    {
        return $this->validated()['person_id'] ?? null;
    }

    /**
     * @return ?string
     */
    public function getPersonFullName(): ?string
    {
        return $this->validated()['person_full_name'] ?? null;
    }

    /**
     * @return int
     */
    public function getManagerId(): int
    {
        return $this->validated()['manager_id'];
    }

    /**
     * @return ?int
     */
    public function getOrganizationId(): ?int
    {
        return $this->validated()['organization_id'] ?? null;
    }

    /**
     * @return string
     */
    public function getOrganizationName(): string
    {
        return $this->validated()['organization_name'];
    }

    /**
     * @return int
     */
    public function getLeadTypeId(): int
    {
        return $this->validated()['lead_type_id'];
    }

    /**
     * @return int
     */
    public function getPipelineStageId(): int
    {
        return $this->validated()['pipeline_stage_id'];
    }
}
