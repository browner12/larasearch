<?php

namespace browner12\larasearch;

use browner12\larasearch\Collections\Results;
use browner12\larasearch\Contracts\Searchable;
use Illuminate\Support\Collection;

class NullSearch implements Searcher
{
    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function create(Searchable $searchable)
    {
        return [];
    }

    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function update(Searchable $searchable)
    {
        return [];
    }

    /**
     * @param \Illuminate\Support\Collection $searchables
     * @param int                            $limit
     * @return mixed
     */
    public function bulk(Collection $searchables, $limit = null)
    {
        return [];
    }

    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function delete(Searchable $searchable)
    {
        return [];
    }

    /**
     * @param string $type
     * @return array
     */
    public function truncateType($type)
    {
        return [];
    }

    /**
     * @return array
     */
    public function truncateIndex()
    {
        return [];
    }

    /**
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function search($query, $page = null, $perPage = null)
    {
        return new Results([]);
    }

    /**
     * @param string $type
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function searchType($type, $query, $page = null, $perPage = null)
    {
        return new Results([]);
    }

    /**
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function autocomplete($query, $page = null, $perPage = null)
    {
        return new Results([]);
    }

    /**
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return mixed
     */
    public function exists(Searchable $searchable)
    {
        return false;
    }

    /**
     * @param string $index
     * @return mixed
     */
    public function createIndex($index)
    {
        return [];
    }

    /**
     * @param string $index
     * @return mixed
     */
    public function deleteIndex($index = null)
    {
        return [];
    }

    /**
     * @return int
     */
    public function getTotalHits()
    {
        return 0;
    }

    /**
     * @return float
     */
    public function getMaxScore()
    {
        return 0.00;
    }
}
