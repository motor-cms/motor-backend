<?php

namespace Motor\Backend\Grid;

use Illuminate\Contracts\Pagination\Paginator;

class SpecialRow extends Base
{

    protected $renderer = 'Motor\Backend\Grid\Renderers\TextRenderer';

    protected $renderOptions = [];

    protected $view;


    public function __construct($view)
    {
        $this->view = $view;
    }


    /**
     * Set column type
     *
     * @param $type
     */
    public function renderer($renderer, $options = [])
    {
        $this->renderer      = $renderer;
        $this->renderOptions = $options;

        return $this;
    }


    public function render(Paginator $paginator)
    {
        // Get renderer
        $renderer = new $this->renderer($this->renderOptions, $paginator);

        // return view
        if ($this->view) {
            return view($this->view, [ 'paginator' => $paginator, 'value' => $renderer->render() ]);
        }
    }
}
