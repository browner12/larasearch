<?php

namespace browner12\larasearch\Events;

use browner12\larasearch\Contracts\Searchable;

class ModelWasIndexed
{
    /**
     * @var \browner12\larasearch\Contracts\Searchable
     */
    public $model;

    /**
     * constructor
     *
     * @param \browner12\larasearch\Contracts\Searchable $model
     */
    public function __construct(Searchable $model)
    {
        //assign
        $this->model = $model;
    }
}
