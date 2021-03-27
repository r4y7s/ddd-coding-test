<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DDDCodeTest\Backoffice\Budgets\Application\Find\BudgetFinder;
use DDDCodeTest\Backoffice\Budgets\Domain\Budget;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetId;
use DDDCodeTest\Backoffice\Budgets\Domain\BudgetNotExist;
use DDDCodeTest\Backoffice\BudgetsLines\Domain\Line;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BudgetShow extends Controller
{
    public function __invoke($invoiceId, JsonResponse $response, BudgetFinder $finder)
    {
        try {
            $budget = $finder(new BudgetId((float)$invoiceId));
        } catch (BudgetNotExist $e) {
            abort(Response::HTTP_NOT_FOUND, $e->getMessage());
        }

        //TODO Make response service
        return $response->setData([
            'budgetId' => $budget->getId()->value(),
            'totalAmount' => $budget->getTotalAmount()->value(),
            'createdAt' => $budget->getCreatedAt()->value(),
            'budgetLine' => $this->getBudgetLineList($budget),
        ]);
    }

    private function getBudgetLineList(Budget $budget): array
    {
        $budgetLine = [];
        foreach ($budget->getBudgetLines()->getIterator() as $line) {
            /**@var Line $line */
            $budgetLine[] = [
                'budgetLineId' => $line->getId()->value(),
                'netAmount' => $line->getNetAmount()->value(),
                'vatAmount' => $line->getVatAmount()->value(),
                'totalAmount' => $line->getTotalAmount()->value(),
                'createdAt' => $line->getCreatedAt()->value(),
            ];
        }

        return $budgetLine;
    }
}
