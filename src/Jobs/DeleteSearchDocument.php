<?php

namespace browner12\larasearch\Jobs;

use browner12\larasearch\Contracts\Searchable;
use browner12\larasearch\Searcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteSearchDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \browner12\larasearch\Contracts\Searchable
     */
    private $searchable;

    /**
     * Create a new job instance.
     *
     * @param \browner12\larasearch\Contracts\Searchable $searchable
     */
    public function __construct(Searchable $searchable)
    {
        //assign
        $this->searchable = $searchable;

        //select queue
        $this->onQueue(config('larasearch.tubes.deleted', 'default'));
    }

    /**
     * Execute the job.
     *
     * @param \browner12\larasearch\Searcher $searcher
     * @return void
     */
    public function handle(Searcher $searcher)
    {
        $searcher->delete($this->searchable);
    }
}
