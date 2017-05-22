<?php namespace browner12\larasearch\Collections;

use Illuminate\Support\Collection;

class Results extends Collection
{
    /**
     *
     *
     * @return float
     */
    public function maximumScore()
    {
        return $this->max('score');
    }

    /**
     * @return float
     */
    public function minimumScore()
    {
        return $this->min('score');
    }

    /**
     * sort the results by their score
     *
     * @param string $order
     * @return string
     */
    public function sortByScore($order = null)
    {
        return $this->sortBy('score', null, ($order == 'asc') ? false : true);
    }

    /**
     * sort the results by their type
     *
     * @param string $order
     * @return string
     */
    public function sortByType($order = null)
    {
        return $this->sortBy(function ($result, $key) {
            return get_class($result);
        }, null, ($order == 'desc') ? true : false);
    }
}
