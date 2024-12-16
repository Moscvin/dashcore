<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;
    protected $query;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->query = $this->model->query();
    }
}