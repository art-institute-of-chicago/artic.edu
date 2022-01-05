<?php

namespace App\Http\Controllers;

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
