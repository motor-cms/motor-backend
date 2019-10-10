<?php

namespace Motor\Backend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * Class JsonRequest
 * @package Motor\Backend\Http\Requests
 */
abstract class JsonRequest extends FormRequest
{

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getValidatorInstance()
    {
        Log::info('Request headers: ' . json_encode(getallheaders()));
        Log::info('Request body: ' . $this->getContent());

        $factory = $this->container->make('Illuminate\Validation\Factory');

        if (method_exists($this, 'validator')) {
            return $this->container->call([ $this, 'validator' ], compact('factory'));
        }
        $data = json_decode($this->getContent(), true);

        return $factory->make(
            $data,
            $this->container->call([ $this, 'rules' ]),
            $this->messages(),
            $this->attributes()
        );
    }
}
