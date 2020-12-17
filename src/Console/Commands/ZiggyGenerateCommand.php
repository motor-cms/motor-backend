<?php

namespace Motor\Backend\Console\Commands;

use Tightenco\Ziggy\CommandRouteGenerator;

class ZiggyGenerateCommand extends CommandRouteGenerator
{
    protected $signature = 'motor:ziggy:generate {path=./resources/assets/js/ziggy.js} {--url=/}';

    public function handle()
    {
        $path = $this->argument('path');

        $generatedRoutes = $this->generate();

        $generatedRoutes = str_replace(config('app.url'), '', $generatedRoutes);

        $this->makeDirectory($path);

        $this->files->put($path, $generatedRoutes);

        $this->info('File generated!');
    }
}
