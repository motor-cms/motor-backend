<?php

namespace Motor\Backend\Grid;

use Illuminate\Support\Arr;

/**
 * Class Base
 */
class Base
{
    protected $attributes = [];

    /**
     * @param $attributes
     * @return $this
     */
    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param $style
     * @return $this
     */
    public function style($style)
    {
        $this->attributes['style'] = $style;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStyle()
    {
        return Arr::get($this->attributes, 'style');
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function buildAttributes()
    {
        if (count($this->attributes) === 0) {
            return '';
        }

        $compiled = '';
        foreach ($this->attributes as $key => $val) {
            $compiled .= ' '.$key.'="'.htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8', true).'"';
        }

        return $compiled;
    }

    /**
     * @param $string
     * @return string|array
     */
    protected function sanitize($string)
    {
        if (! is_array($string)) {
            return nl2br(htmlspecialchars($string));
        }

        return $string;
    }
}
