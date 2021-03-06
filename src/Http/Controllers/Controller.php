<?php

namespace Motor\Backend\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Locale;
use Motor\Backend\Models\User;

/**
 * Class Controller
 *
 * @package Motor\Backend\Http\Controllers
 */
class Controller extends BaseController
{
    protected string $userModel = User::class;

    protected string $modelResource = '';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if ($this->userModel && $this->modelResource) {
            $this->authorizeResource($this->userModel, $this->modelResource);
        }
        Locale::setDefault(config('app.locale'));
    }
}
