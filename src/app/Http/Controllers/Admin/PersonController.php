<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\DeleteCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Requests\Admin\Person\CreatePersonRequest;
use App\Http\Requests\Admin\Person\DeletePersonRequest;
use App\Http\Requests\Admin\Person\GetPersonRequest;
use App\Http\Requests\Admin\Person\UpdatePersonRequest;
use App\Models\Category;
use App\Repositories\CRM\PersonRepositoryInterface;
use App\Services\Core\CompanyProtection\CheckCompanyAccess;
use App\Services\Core\CompanyProtection\CompanyProtectionContract;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class PersonController extends Controller implements CompanyProtectionContract
{
    use CheckCompanyAccess;

    protected PersonRepositoryInterface $personRepository;
    protected LoggerInterface $logger;

    public function __construct(
        PersonRepositoryInterface $personRepository,
        LoggerInterface $logger,
    ) {
        $this->personRepository = $personRepository;
        $this->logger = $logger;

        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_CREATE_PERSON,
            ['only' => ['create']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_UPDATE_PERSON,
            ['only' => ['update']]);
        $this->middleware(
            'permission:' . \App\Models\Permission::CAN_DELETE_PERSON,
            ['only' => ['delete']]);
    }

    /**
     * @param GetPersonRequest $request
     * @return JsonResponse
     */
    public function list(GetPersonRequest $request): JsonResponse
    {
        $persons = $this->personRepository->get(
            $request->company()
        );

        return response()->json([
            'persons' => $persons->toArray(),
        ]);
    }

    /**
     * @param CreatePersonRequest $request
     * @return JsonResponse
     */
    public function create(
        CreatePersonRequest $request
    ): JsonResponse {
        $person = $this->personRepository->store(
            $request->company(),
            $request->getFirstName(),
            $request->getLastName(),
            $request->getMiddleName()
        );

        return response()->json([
            'person' => $person->toArray(),
        ]);
    }

    /**
     * @param UpdatePersonRequest $request
     * @return JsonResponse
     */
    public function update(
        UpdatePersonRequest $request
    ): JsonResponse {
        $person = $this->personRepository->find($request->getPersonId());
        $person = $this->personRepository->update(
            $person,
            $request->getFirstName(),
            $request->getLastName(),
            $request->getMiddleName()
        );

        return response()->json([
            'person' => $person->toArray(),
        ]);
    }

    /**
     * @param DeletePersonRequest $request
     * @return JsonResponse
     */
    public function delete(
        DeletePersonRequest $request
    ): JsonResponse {
        $person = $this->personRepository->find($request->getPersonId());
        $isDeleted = $this->personRepository->delete($person);

        return response()->json([
            'status' => $isDeleted ? 'ok' : 'error',
        ]);
    }
}
