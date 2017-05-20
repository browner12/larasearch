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
        return $this->app['config']['search.driver'];
    }

    /**
     * @return \browner12\larasearch\ElasticSearch
     */
    protected function createElasticsearchDriver()
    {
        $hosts = [];

        foreach($this->app['config']['search.hosts'] as $host){
            $hosts[] = $this->app['config']['search.connections.' . $host];
        }

        return new ElasticSearch($this->app['config']['search.index'], $hosts);
    }
}
