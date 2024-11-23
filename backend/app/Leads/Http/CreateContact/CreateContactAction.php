<?php declare(strict_types=1);

namespace App\Leads\Http\CreateContact;

use App\Leads\Service\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CreateContactAction extends Controller
{
    public function __construct(private readonly LeadService $service)
    {
    }

    public function __invoke(int $leadId, CreateContactRequest $request): JsonResponse
    {
        return new JsonResponse($this->service->createContact(
            $leadId,
            $request->validated(),
        ));
    }
}
