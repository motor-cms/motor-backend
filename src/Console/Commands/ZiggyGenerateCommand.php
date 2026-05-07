<?php

namespace Motor\Backend\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Tighten\Ziggy\Output\File;
use Tighten\Ziggy\Ziggy;

class ZiggyGenerateCommand extends Command
{
    protected $signature = 'motor:ziggy:generate {path=./resources/assets/js/ziggy.js} {--url=/}';

    protected $description = 'Generate Ziggy routes JS file with app.url stripped from output.';

    public function handle(Filesystem $filesystem): void
    {
        $ziggy = new Ziggy(null, $this->option('url') ? url($this->option('url')) : null);

        $path = $this->argument('path');

        $filesystem->ensureDirectoryExists(dirname(base_path($path)), recursive: true);

        $generatedRoutes = (string) new File($ziggy);
        $generatedRoutes = str_replace((string) config('app.url'), '', $generatedRoutes);

        $filesystem->put(base_path($path), $generatedRoutes);

        $this->info('File generated!');
    }
}
