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
    public function getSearchTitle();

    /**
     * @return string
     */
    public function getSearchUrl();

    /**
     * @return string
     */
    public function getSearchImage();

    /**
     * @return string
     */
    public function getSearchView();

    /**
     * @return string
     */
    public function getSearchContent();
}
