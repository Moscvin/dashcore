<?php

namespace App\Console\Commands\Webhooks;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OnPushCommand extends Command
{
    protected $signature = 'git:onpush';
    protected $description = 'Call commands to perform pull action';
    private $fileName;

    public function __construct()
    {
        $this->filename = date('Ymd_His') . 'push.log';
        parent::__construct();
    }

    public function handle()
    {
        $this->runPull();
        $this->runOptimize();
        // $this->runMigrate();
        //$this->runComposer();
    }

    private function runPull()
    {
        $this->writeLog("Running 'git pull'");
        $process = exec("cd " . base_path() . " && /usr/bin/git pull origin main", $output);
        foreach ($output as $line) {
            $this->writeLog($line);
        }
    }

    private function runComposer()
    {
        $this->writeLog("Running 'composer update'");
        $process = exec("cd " . base_path() . " && /usr/bin/composer update", $output);
        foreach ($output as $line) {
            $this->writeLog($line);
        }
    }

    private function runMigrate()
    {
        $this->writeLog("Running 'php artisan migrate'");
        $process = exec("php " . base_path() . "/artisan migrate", $output);
        foreach ($output as $line) {
            $this->writeLog($line);
        }
    }

    private function runOptimize()
    {
        $this->writeLog("Running 'php artisan migrate'");
        $process = exec("php " . base_path() . "/artisan optimize", $output);
        foreach ($output as $line) {
            $this->writeLog($line);
        }
    }

    private function writeLog($message)
    {
        Storage::append("webhooks/" . $this->filename, $message);
    }
}