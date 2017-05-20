<?php

namespace browner12\larasearch;

use browner12\larasearch\Contracts\Searchable;
use Illuminate\Support\Collection;

interface Searcher
{
    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function create(Searchable $searchable);

    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function update(Searchable $searchable);

    /**
     * @param \Illuminate\Support\Collection $searchables
     * @param int                            $limit
     * @return mixed
     */
    public function bulk(Collection $searchables, $limit = null);

    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function delete(Searchable $searchable);

    /**
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function search($query, $page = null, $perPage = null);

    /**
     * @param string $type
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function searchType($type, $query, $page = null, $perPage = null);

    /**
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function autocomplete($query, $page = null, $perPage = null);
}
