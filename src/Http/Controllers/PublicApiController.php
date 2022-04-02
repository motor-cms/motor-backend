<?php

namespace Motor\Backend\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Locale;

/**
 * Class PublicApiController
 *
 * @package Motor\Backend\Http\Controllers
 */
class PublicApiController extends BaseController
{
    protected string $modelResource = '';

    protected string $model = '';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Locale::setDefault(config('app.locale'));
    }
}
