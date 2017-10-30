<?php

namespace browner12\larasearch;

use Illuminate\Support\Manager;

class SearchManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['larasearch.driver'];
    }

    /**
     * @return \browner12\larasearch\ElasticSearch
     */
    protected function createElasticsearchDriver()
    {
        $hosts = [];

        foreach($this->app['config']['larasearch.hosts'] as $host){
            $hosts[] = $this->app['config']['larasearch.connections.' . $host];
        }

        return new ElasticSearch($this->app['config']['larasearch.index'], $hosts);
    }

    /**
     * @return \browner12\larasearch\NullSearch
     */
    protected function createNullDriver()
    {
        return new NullSearch();
    }
}
