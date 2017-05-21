<?php

namespace browner12\larasearch\Contracts;

interface Searchable
{
    /**
     * @return string
     */
    public function getSearchType();

    /**
     * @return mixed
     */
    public function getSearchId();

    /**
     * @return string
     */
    public function getSearchContent();
}
