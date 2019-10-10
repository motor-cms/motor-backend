<?php

namespace Motor\Backend\Http\Controllers;

use Illuminate\Support\Arr;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\ResourceAbstract;
use Motor\Backend\Forms\Fields\DatepickerType;
use Motor\Backend\Forms\Fields\DatetimepickerType;
use Motor\Backend\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\CheckableType;
use Kris\LaravelFormBuilder\Fields\SelectType;
use Kris\LaravelFormBuilder\Form;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class Controller
 * @package Motor\Backend\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $fractal;


    public function __construct()
    {
        \Locale::setDefault(config('app.locale'));
        $this->fractal = new Manager();
    }


    /**
     * @param        $record
     * @param        $transformer
     * @param string $includes
     * @return Item
     */
    protected function transformItem($record, $transformer, $includes = '')
    {
        $this->fractal->parseIncludes($includes);

        return new Item($record, ( new $transformer ));
    }


    /**
     * @param        $collection
     * @param        $transformer
     * @param string $includes
     * @return Collection
     */
    protected function transformCollection($collection, $transformer, $includes = '')
    {
        $this->fractal->parseIncludes($includes);

        return new Collection($collection, ( new $transformer ));
    }


    /**
     * @param        $paginator
     * @param        $transformer
     * @param string $includes
     * @return Collection
     */
    protected function transformPaginator($paginator, $transformer, $includes = '')
    {
        $this->fractal->parseIncludes($includes);
        $resource = new Collection($paginator->getCollection(), ( new $transformer ));
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $resource;
    }


    /**
     * @param $message
     * @param $data
     * @param $filename
     * @return mixed
     */
    protected function respondWithJsonDownload($message, $data, $filename)
    {
        $meta = null;
        if ($data instanceof ResourceAbstract) {
            $data = $this->fractal->createData($data)->toArray();
            $meta = Arr::get($data, 'meta', null);
            $data = Arr::get($data, 'data');
        }
        if (! is_null($meta)) {
            $json = json_encode([ 'message' => $message, 'data' => $data, 'meta' => $meta ]);
        } else {
            $json = json_encode([ 'message' => $message, 'data' => $data ]);
        }

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, $filename, ['Content-Type' => 'application/json']);
    }


    /**
     * @param $message
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithJson($message, $data)
    {
        $meta = null;
        if ($data instanceof ResourceAbstract) {
            $data = $this->fractal->createData($data)->toArray();
            $meta = Arr::get($data, 'meta', null);
            $data = Arr::get($data, 'data');
        }
        if (! is_null($meta)) {
            return response()->json([ 'message' => $message, 'data' => $data, 'meta' => $meta ]);
        }

        return response()->json([ 'message' => $message, 'data' => $data ]);
    }
}
