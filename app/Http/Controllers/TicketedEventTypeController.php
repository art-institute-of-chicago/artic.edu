<?php

namespace App\Http\Controllers;

use App\Repositories\TicketedEventTypeRepository;

class TicketedEventTypeController extends FrontController
{
    protected $repository;

    public function __construct(TicketedEventTypeRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function index()
    {
        return $this->repository->listAll();
    }

    public function show($id)
    {
        return $this->repository->getById((int) $id);
    }
}
