<?php

namespace Motor\Backend\Grid;

use Illuminate\Contracts\Pagination\Paginator;

/**
 * Class SpecialRow
 * @package Motor\Backend\Grid
 */
class SpecialRow extends Base
{

    protected $renderer = 'Motor\Backend\Grid\Renderers\TextRenderer';

    protected $renderOptions = [];

    protected $view;


    /**
     * SpecialRow constructor.
     * @param $view
     */
    public function __construct($view)
    {
        $this->view = $view;
    }


    /**
     * Set column type
     *
     * @param       $renderer
     * @param array $options
     *
     * @return $this
     */
    public function renderer($renderer, array $options = [])
    {
        $this->renderer      = $renderer;
        $this->renderOptions = $options;

        return $this;
    }


    /**
     * @param Paginator $paginator
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
