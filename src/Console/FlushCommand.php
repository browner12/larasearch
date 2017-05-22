<?php

namespace browner12\larasearch\Console;

use browner12\larasearch\Searcher;
use Illuminate\Console\Command;

class FlushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:flush {model?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush records from the index';

    /**
     * Execute the console command.
     *
     * @param \browner12\larasearch\Searcher $search
     * @return void
     */
    public function handle(Searcher $search)
    {
        $class = $this->argument('model');

        //flush the index
        if (is_null($class)) {

            if ($this->confirm('Are you sure you want to flush the entire index?')) {
                $search->truncateIndex();
            }

            $this->info('The entire index has been flushed.');
        }

        //only flush specific class
        else {

            $class = $this->qualifyClass($class);

            if ($this->confirm('Are you sure you want to flush the ' . $class .' index?')) {
                $search->truncateType($class);
            }

            $this->info('The ' . $class . ' index has been flushed.');
        }
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
