<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class TodoFilter
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        if ($this->request->has('category')) {
            $query->where('category', $this->request->get('category'));
        }

        if ($this->request->has('status')) {
            $query->where('status', $this->request->get('status'));
        }

        if ($this->request->has('completed')) {
            $query->where('completed', $this->request->get('completed'));
        }

        if ($this->request->has('due_date')) {
            $query->whereDate('due_date', '<=', $this->request->get('due_date'));
        }

        return $query;
    }
}
