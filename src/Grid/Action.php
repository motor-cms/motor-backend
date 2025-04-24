<?php

namespace Motor\Backend\Grid;

use Illuminate\Database\Eloquent\Model;
use View;

/**
 * Class Action
 */
class Action extends Base
{
    protected $link = '';

    protected $label = '';

    protected $parameters = [];

    protected $value = '';

    protected $type = 'button';

    protected $permission = '';

    protected $conditionColumn = null;

    protected $conditionValue = null;

    protected $conditionOperator = '=';

    protected $askForConfirmation = false;

    protected $confirmationMessage = '';

    /**
     * Action constructor.
     */
    public function __construct(string $label, string $link, array $parameters = [])
    {
        $this->label = $label;
        $this->link = $link;
        $this->parameters = $parameters;

        if (isset($parameters['type'])) {
            $this->type = $parameters['type'];
        }
    }

    /**
     * @return $this
     */
    public function needsPermissionTo(string $permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return $this
     */
    public function askForConfirmation(bool $confirmation = true, string $message = '')
    {
        $this->askForConfirmation = $confirmation;
        $this->confirmationMessage = $message;
        if ($this->askForConfirmation) {
            $this->parameters['ask_for_confirmation_class'] = 'ask-for-confirmation';
        }
        $this->parameters['confirmation_message'] = $this->confirmationMessage;

        return $this;
    }

    /**
     * @return $this
     */
    public function onCondition(string $column, $value, string $operator = '=')
    {
        $this->conditionColumn = $column;
        $this->conditionValue = $value;
        $this->conditionOperator = $operator;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return array|bool|string
     *
     * @throws \Throwable
     */
    public function render(Model $record)
    {
        if ($this->permission != '' && ! has_permission($this->permission)) {
            return false;
        }

        if (! is_null($this->conditionColumn)) {
            $condition = false;

            switch ($this->conditionOperator) {
                case '=':
                    if ($record->{$this->conditionColumn} == $this->conditionValue) {
                        $condition = true;
                    }
                    break;
                case '!=':
                    if ($record->{$this->conditionColumn} != $this->conditionValue) {
                        $condition = true;
                    }
                    break;
                case '>':
                    if ($record->{$this->conditionColumn} > $this->conditionValue) {
                        $condition = true;
                    }
                    break;
                case '<':
                    if ($record->{$this->conditionColumn} < $this->conditionValue) {
                        $condition = true;
                    }
                    break;
                case '>=':
                    if ($record->{$this->conditionColumn} >= $this->conditionValue) {
                        $condition = true;
                    }
                    break;
                case '<=':
                    if ($record->{$this->conditionColumn} <= $this->conditionValue) {
                        $condition = true;
                    }
                    break;
            }

            if (! $condition) {
                return false;
            }
        }

        switch ($this->type) {
            case 'form':
                $view = 'motor-backend::grid.actions.form';
                break;
            case 'duplicate':
                $view = 'motor-backend::grid.actions.duplicate';
                break;
            case 'edit':
                $view = 'motor-backend::grid.actions.edit';
                break;
            case 'delete':
                $view = 'motor-backend::grid.actions.delete';
                break;
            default:
                $view = 'motor-backend::grid.actions.button';
        }

        return View::make($view, [
            'link' => $this->link,
            'record' => $record,
            'label' => $this->label,
            'parameters' => $this->parameters,
        ])
            ->render();
    }
}
