<?php

namespace browner12\larasearch;

use browner12\larasearch\Collections\Results;
use browner12\larasearch\Contracts\Searchable;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Collection;

class ElasticSearch implements Searcher
{
    /**
     * @var string
     */
    protected $index;

    /**
     * @var \Elasticsearch\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $resultMeta;

    /**
     * constructor
     *
     * @param string $index
     * @param array  $hosts
     */
    public function __construct($index, $hosts = null)
    {
        //set index
        $this->index = $index;

        //create client
        $this->client = ClientBuilder::create()
                                     ->setHosts($hosts)
                                     ->build();
    }

    /**INDEXING**/

    /**
     * add a model to the index
     *
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return array|mixed
     */
    public function create(Searchable $searchable)
    {
        return $this->client->index([
            'index' => $this->index,
            'type'  => $searchable->getSearchType(),
            'id'    => $searchable->getSearchId(),
            'body'  => [
                'model'   => get_class($searchable),
                'content' => $searchable->getSearchContent(),
            ],
        ]);
    }

    /**
     * update a model in the index
     *
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return array|mixed
     */
    public function update(Searchable $searchable)
    {
        if (!$this->exists($searchable)) {
            return $this->create($searchable);
        }

        return $this->client->update([
            'index' => $this->index,
            'type'  => $searchable->getSearchType(),
            'id'    => $searchable->getSearchId(),
            'body'  => [
                'doc' => [
                    'content' => $searchable->getSearchContent(),
                ],
            ],
        ]);
    }

    /**
     * bulk insert models into the index
     *
     * @param \Illuminate\Support\Collection $searchables
     * @param int                            $limit
     * @return mixed|void
     */
    public function bulk(Collection $searchables, $limit = 1000)
    {
        foreach ($searchables->chunk($limit) as $chunk) {

            foreach ($chunk as $searchable) {

                $params['body'][] = [
                    'index' => [
                        '_index' => $this->index,
                        '_type'  => $searchable->getSearchType(),
                        '_id'    => $searchable->getSearchId(),
                    ],
                ];

                $params['body'][] = [
                    'model'   => get_class($searchable),
                    'content' => $searchable->getSearchContent(),
                ];
            }

            $this->client->bulk($params);
        }
    }

    /**
     * delete a model from the index
     *
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return array|mixed
     */
    public function delete(Searchable $searchable)
    {
        return $this->client->delete([
            'index' => $this->index,
            'type'  => $searchable->getSearchType(),
            'id'    => $searchable->getSearchId(),
        ]);
    }

    /**
     * truncate type from the index
     *
     * @param string $type
     * @return array
     */
    public function truncateType($type)
    {
        return $this->client->delete([
            'index' => $this->index,
            'type'  => $type,
        ]);
    }

    /**
     * truncate the index
     *
     * @return array
     */
    public function truncateIndex()
    {
        return $this->client->indices()->delete([
            'index' => $this->index,
        ]);
    }

    /**SEARCHING**/

    /**
     * perform a basic search
     *
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function search($query, $page = 1, $perPage = 20)
    {
        $results = $this->client->search([
            'index' => $this->index,
            'body'  => [
                'size'  => $perPage,
                'from'  => ($page - 1) * $perPage,
                'query' => [
                    'match' => [
                        'content' => $query,
                    ],
                ],
            ],
        ]);

        $this->setResultMeta($results);

        return $this->hitsToEloquent($results['hits']['hits']);
    }

    /**
     * perform a search on a specific model type
     *
     * @param string $type
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function searchType($type, $query, $page = 1, $perPage = 20)
    {
        $results = $this->client->search([
            'index' => $this->index,
            'type'  => $type,
            'body'  => [
                'size'  => $perPage,
                'from'  => ($page - 1) * $perPage,
                'query' => [
                    'match' => [
                        'content' => $query,
                    ],
                ],
            ],
        ]);

        $this->setResultMeta($results);

        return $this->hitsToEloquent($results['hits']['hits']);
    }

    /**
     * perform an autocomplete search
     *
     * @param string $query
     * @param int    $page
     * @param int    $perPage
     * @return \browner12\larasearch\Collections\Results
     */
    public function autocomplete($query, $page = 1, $perPage = 20)
    {
        $results = $this->client->search([
            'index' => $this->index,
            'body'  => [
                'size'  => $perPage,
                'from'  => ($page - 1) * $perPage,
                'query' => [
                    'match_phrase_prefix' => [
                        'content' => $query,
                    ],
                ],
            ],
        ]);

        $this->setResultMeta($results);

        return $this->hitsToEloquent($results['hits']['hits']);
    }

    /**
     * check if the given model exists in the search index
     *
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     * @return array|bool
     */
    public function exists(Searchable $searchable)
    {
        return $this->client->exists([
            'index' => $this->index,
            'type'  => $searchable->getSearchType(),
            'id'    => $searchable->getSearchId(),
        ]);
    }

    /**
     * turn elasticsearch hits into Eloquent models
     *
     * @param array $hits
     * @return \browner12\larasearch\Collections\Results
     */
    protected function hitsToEloquent($hits)
    {
        //initialize
        $return = [];

        //loop
        foreach ($hits as $hit) {

            $model = '\\' . $hit['_source']['model'];

            $object = $model::find($hit['_id']);

            if ($object) {

                $object->score = $hit['_score'];

                $return[] = $object;
            }
        }

        //return
        return new Results($return);
    }

    /**MANAGEMENT**/

    /**
     * create an index
     *
     * @param string $name
     * @return array
     */
    public function createIndex($name = null)
    {
        $index = ($name) ?: $this->index;

        return $this->client->indices()->create(['index' => $index]);
    }

    /**
     * delete an index
     *
     * @param string $name
     * @return array
     */
    public function deleteIndex($name = null)
    {
        $index = ($name) ?: $this->index;

        return $this->client->indices()->delete(['index' => $index]);
    }

    /**HELPERS**/

    /**
     * set result meta data
     *
     * @param $result
     */
    protected function setResultMeta($result)
    {
        $this->resultMeta['took'] = isset($result['took']) ? $result['took'] : null;
        $this->resultMeta['timed_out'] = isset($result['timed_out']) ? $result['timed_out'] : null;
        $this->resultMeta['shards'] = isset($result['_shards']) ? $result['_shards'] : null;
        $this->resultMeta['total'] = isset($result['hits']['total']) ? $result['hits']['total'] : null;
        $this->resultMeta['max_score'] = isset($result['hits']['max_score']) ? $result['hits']['max_score'] : null;
    }

    /**
     * get the total hits of a search
     *
     * @return int
     */
    public function getTotalHits()
    {
        return isset($this->resultMeta['totalHits']) ? $this->resultMeta['totalHits'] : null;
    }

    /**
     * @return float
     */
    public function getMaxScore()
    {
        return isset($this->resultMeta['maxScore']) ? $this->resultMeta['totalHits'] : null;
    }
}
