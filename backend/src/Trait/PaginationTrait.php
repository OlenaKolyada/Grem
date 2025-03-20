<?php

namespace App\Trait;

use Symfony\Component\HttpFoundation\Request;

trait PaginationTrait
{
    protected function preparePaginationCriteria(Request $request): array
    {
        $statusParam = $request->query->get('status', 'Published');
        $page = (int)$request->query->get('page', 1);
        $limit = (int)$request->query->get('limit', 9);

        $criteria = [];
        if ($statusParam) {
            $criteria['status'] = $statusParam;
        }

        return [
            'criteria' => $criteria,
            'page' => $page,
            'limit' => $limit
        ];
    }
}