<?php

namespace Motor\Backend\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use Motor\Backend\Models\User;

/**
 * Class Controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected string $userModel = User::class;

    protected string $modelResource = '';

    protected $fractal;

    public function __construct()
    {
        if ($this->userModel && $this->modelResource) {
            $this->authorizeResource($this->userModel, $this->modelResource);
        }
        \Locale::setDefault(config('app.locale'));
        $this->fractal = new Manager;
    }

    /**
     * @param  string  $includes
     * @return Item
     */
    protected function transformItem($record, $transformer, $includes = '')
    {
        $this->fractal->parseIncludes($includes);

        return new Item($record, (new $transformer));
    }

    /**
     * @param  string  $includes
     * @return Collection
     */
    protected function transformCollection($collection, $transformer, $includes = '')
    {
        $this->fractal->parseIncludes($includes);

        return new Collection($collection, (new $transformer));
    }

    /**
     * @param  string  $includes
     * @return Collection
     */
    protected function transformPaginator($paginator, $transformer, $includes = '')
    {
        $this->fractal->parseIncludes($includes);
        $resource = new Collection($paginator->getCollection(), (new $transformer));
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $resource;
    }

    /**
     * @return mixed
     */
    protected function respondWithJsonDownload($message, $data, $filename)
    {
        $meta = null;
        if ($data instanceof ResourceAbstract) {
            $data = $this->fractal->createData($data)
                ->toArray();
            $meta = Arr::get($data, 'meta', null);
            $data = Arr::get($data, 'data');
        }
        if (! is_null($meta)) {
            $json = json_encode(['message' => $message, 'data' => $data, 'meta' => $meta]);
        } else {
            $json = json_encode(['message' => $message, 'data' => $data]);
        }

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, $filename, ['Content-Type' => 'application/json']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithJson($message, $data, $status = 200)
    {
        $meta = null;
        if ($data instanceof ResourceAbstract) {
            $data = $this->fractal->createData($data)
                ->toArray();
            $meta = Arr::get($data, 'meta', null);
            $data = Arr::get($data, 'data');
        }
        if (! is_null($meta)) {
            return response()->json(['message' => $message, 'data' => $data, 'meta' => $meta], $status);
        }

        return response()->json(['message' => $message, 'data' => $data], $status);
    }
}
