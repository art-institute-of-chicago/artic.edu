<?php

namespace App\Http\Controllers;

use App\Repositories\Api\TicketedEventRepository;

class TicketedEventController extends FrontController
{
    protected $repository;

    public function __construct(TicketedEventRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function index()
    {

        return $this->repository->listAll()

    }

    public function show($id)
    {

        return $this->repository->getById((Integer) $id);

    }

}
