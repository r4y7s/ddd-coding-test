<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetStoreRequest;
use DDDCodeTest\Backoffice\Budgets\Application\Create\BudgetCreator;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class BudgetStore extends Controller
{
    public function __invoke(BudgetStoreRequest $request, JsonResponse $response, BudgetCreator $creator)
    {
        try {
            $creator($request->toArray());
            return $response->setStatusCode(Response::HTTP_CREATED);
        } catch (InvalidArgumentException $e) {
            abort(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}
