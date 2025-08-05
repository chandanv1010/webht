<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Repositories\BaseRepository;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    protected $model;

    public function __construct(
        Contact $model
    ){
        $this->model = $model;
    }

}