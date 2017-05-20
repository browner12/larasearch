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
    private $index;

    /**
     * @var \Elasticsearch\Client
     */
    private $client;

    /**
     * @var int
     */
    public $totalHits;

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
                'content' => $searchable->getSearchContent(),
            ],
        ]);
    }

    /**
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
                    'content' => $searchable->getSearchContent(),
                ];
            }

            $this->client->bulk($params);
        }
    }

    /**
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

    /**SEARCHING**/

    /**
     * basic search
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

        $this->totalHits = $results['hits']['total'];

        return $this->hitsToEloquent($results);
    }

    /**
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

        $this->totalHits = $results['hits']['total'];

        return $this->hitsToEloquent($results);
    }

    /**
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

        $this->totalHits = $results['hits']['total'];

        return $this->hitsToEloquent($results);
    }

    /**
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
     * @param array $results
     * @return \browner12\larasearch\Collections\Results
     */
    public function hitsToEloquent($results)
    {
        //initialize
        $return = [];

        //loop
        foreach ($results['hits']['hits'] as $hit) {

            $model = '\\' . $hit['_type'];

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
     * @param string $name
     * @return array
     */
    public function createIndex($name = null)
    {
        $index = ($name) ?: $this->index;

        return $this->client->indices()->create(['index' => $index]);
    }

    /**
     * @param string $name
     * @return array
     */
    public function deleteIndex($name = null)
    {
        $index = ($name) ?: $this->index;

        return $this->client->indices()->delete(['index' => $index]);
    }
}
