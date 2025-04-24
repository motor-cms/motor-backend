<?php

namespace Motor\Backend\Grid\Renderers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use NumberFormatter;

/**
 * Class CurrencyRenderer
 */
class CurrencyRenderer
{
    protected $value = '';

    protected $options = [];

    protected $record;

    protected $defaultCurrency = 'EUR';

    /**
     * CurrencyRenderer constructor.
     */
    public function __construct($value, array $options = [], ?Model $record = null)
    {
        $this->value = $value;
        $this->options = $options;
        $this->record = $record;
    }

    /**
     * @return string
     */
    public function render()
    {
        if ($this->value == '' || $this->value == null) {
            return '';
        }

        $currency = Arr::get($this->options, 'currency');
        if (is_null($currency) && Arr::get($this->options, 'currency_column')) {
            $currency = $this->record->{$this->options['currency_column']};
        }
        if (is_null($currency)) {
            $currency = $this->defaultCurrency;
        }

        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
        $value = $formatter->formatCurrency((float) $this->value, $currency);

        if ((float) $this->value < 0) {
            return '<span style="color: red;">'.$value.'</span>';
        }

        return $value;
    }
}
