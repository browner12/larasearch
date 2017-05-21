<?php

namespace browner12\larasearch\Concerns;

use browner12\larasearch\SearchObserver;

trait CanBeSearched
{
    /**
     * boot the trait
     */
    public static function bootCanBeSearched()
    {
        static::observe(SearchObserver::class);
    }

    /**
     * @return string
     */
    public function getSearchType()
    {
        return get_class($this);
    }

    /**
     * @return mixed
     */
    public function getSearchId()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function gtSearchContent()
    {
        return $this->toArray();
    }
}
