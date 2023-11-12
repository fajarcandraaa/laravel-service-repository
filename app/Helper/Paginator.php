<?php

namespace App\Helper;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends LengthAwarePaginator {
    public function toArray()
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items->toArray(),
            'from' => $this->firstItem(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'to' => $this->lastItem(),
            'total' => $this->total(),
        ];
    }
}