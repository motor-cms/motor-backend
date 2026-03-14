<?php

namespace Motor\Backend\Observers;

use Illuminate\Support\Facades\Cache;
use Motor\Backend\Models\ConfigVariable;

class ConfigVariableObserver
{
    public function saved(ConfigVariable $configVariable): void
    {
        Cache::forget('config_variables_all');
    }

    public function deleted(ConfigVariable $configVariable): void
    {
        Cache::forget('config_variables_all');
    }
}
