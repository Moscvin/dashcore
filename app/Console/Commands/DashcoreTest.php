<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\DashcoreTestJob;

class DashcoreTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashcore:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rewrite file in storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new DashcoreTestJob('datetime.txt'));
        return 0;
    }
}
