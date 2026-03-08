<?php

namespace Motor\Backend\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Tighten\Ziggy\CommandRouteGenerator;
use Tighten\Ziggy\Output\File;
use Tighten\Ziggy\Ziggy;

class ZiggyGenerateCommand extends CommandRouteGenerator
{
    protected $signature = 'motor:ziggy:generate {path=./resources/assets/js/ziggy.js} {--url=/} {--group=}';

    public function handle(Filesystem $filesystem)
    {
        $path = $this->argument('path');

        $ziggy = new Ziggy($this->option('group'), $this->option('url') ? url($this->option('url')) : null);

        $output = new File($ziggy);
        $generatedRoutes = str_replace(config('app.url'), '', (string) $output);

        $filesystem->ensureDirectoryExists(dirname(base_path($path)), recursive: true);
        $filesystem->put(base_path($path), $generatedRoutes);

        $this->info('File generated!');
    }
}
