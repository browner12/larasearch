<?php

namespace browner12\larasearch;

use browner12\larasearch\Jobs\CreateSearchDocument;
use browner12\larasearch\Jobs\DeleteSearchDocument;
use browner12\larasearch\Jobs\UpdateSearchDocument;

class SearchObserver
{
    /**
     * @var \browner12\larasearch\Searcher
     */
    private $searcher;

    /**
     * constructor
     *
     * @param \browner12\larasearch\Searcher $searcher
     */
    public function __construct(Searcher $searcher)
    {
        //assign
        $this->search = $searcher;
    }

    /**
     * @param $model
     */
    public function created($model)
    {
        if (config('search.queue.created', false)) {
            dispatch(new CreateSearchDocument($model));
        }

        $this->searcher->create($model);
    }

    /**
     * @param $model
     */
    public function updated($model)
    {
        if (config('search.queue.updated', false)) {
            dispatch(new UpdateSearchDocument($model));
        }

        $this->searcher->update($model);
    }

    /**
     * @param $model
     */
    public function deleted($model)
    {
        if (config('search.queue.deleted', false)) {
            dispatch(new DeleteSearchDocument($model));
        }

        $this->searcher->delete($model);
    }
}
