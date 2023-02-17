<?php

namespace App\Admin\Repositories;

use App\Models\AppList as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AppList extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
