<?php

namespace browner12\larasearch\Console;

use browner12\larasearch\Searcher;
use Illuminate\Console\Command;

class IndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:import {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the given model into the search index';

    /**
     * Execute the console command.
     *
     * @param \browner12\larasearch\Searcher $search
     * @return void
     */
    public function handle(Searcher $search)
    {
        $class = $this->argument('model');

        if (is_null($class)) {
            $classes = config('search.models');
        }

        else {
            $classes = [$this->qualifyClass($class)];
        }

        foreach ($classes as $class) {

            $models = $class::all();

            $search->bulk($models);

            $this->comment('Imported [' . $class . '] models.');
        }

        $this->info('All records have been imported.');
    }

    /**
     * Fix class names with slashes.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return str_replace('/', '\\', $name);
    }
}
