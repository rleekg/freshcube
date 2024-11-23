<?php declare(strict_types=1);

namespace App\Leads\Http;

use App\Leads\Service\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ListAction extends Controller
{
    public function __construct(private readonly LeadService $service)
    {
    }

    public function __invoke(): JsonResponse
    {
        return new JsonResponse($this->service->getLeads());
    }
}
