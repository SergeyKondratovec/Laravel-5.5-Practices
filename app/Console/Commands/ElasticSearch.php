<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SphereMall\Elastic\Elastic;
use SphereMall\Elastic\Helpers\IndexHelper;

class ElasticSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sm:elastic
                           {action : Actions of elastic}
                           {--index= : Index name for action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elastic search commands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        $index = $this->option('index');

        if (IndexHelper::isAvailableIndex($index) === false) {
            $this->error("Index name[$index] was not found!");
            return false;
        }

        switch ($action) {
            case 'search':
                break;

            case 'revert':
                $startTime = microtime(true);
                $this->info("Start reverting...");
                $this->delete($index);
                $this->info("Deleted");
                $this->map($index);
                $this->info("Mapped");
                $this->create($index);
                $this->info("Created");
                $this->info("Reverting was finished");
                $this->info("Time: " . round((microtime(true) - $startTime), 3));
                $this->info("Memory: " . round(memory_get_usage() / 1024 / 1024, 2));
                break;

            case 'map':
                $this->info("Start mapping...");
                $this->map($index);
                $this->info("Mapping was finished");
                break;

            case 'create':
                $this->info("Start creating...");
                $this->create($index);
                $this->info("Creating was finished");
                break;

            case 'delete':
                $this->info("Start deleting...");
                $this->delete($index);
                $this->info("Deleting was finished");
                break;

            case 'test':
                $this->info("Test...");
                $this->test();
                break;

            default:
                $this->error("Action {$action} is not available. Available actions: ['map']");
        }

        return true;
    }

    private function test()
    {
        $elastic = new Elastic();
    }

    private function map($index)
    {
        $elastic = new Elastic();
        $elastic->mapping($index);
    }

    private function create($index)
    {
        $elastic = new Elastic();

        $elastic->indexing($index);
    }

    private function delete($index)
    {
        $elastic = new Elastic();
        $elastic->delete($index);
    }
}
