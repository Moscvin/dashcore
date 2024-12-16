<?php

namespace App\Traits\Core;

trait DatabaseMigrationTrait
{
    public function getMigrationPaths()
    {
        return $this->getInnerDirectories([database_path('migrations')], database_path('migrations'));
    }

    private function getInnerDirectories($paths, $path)
    {

        $directories = glob($path . '/*', GLOB_ONLYDIR);

        foreach ($directories as $directory) {
            $paths = array_merge($paths, $this->getInnerDirectories($paths, $directory));
        }

        $paths = array_merge($paths, $directories);
        return $paths;
    }
}
