<?php namespace Argentum88\Phad\FormItems;

use Argentum88\Phad\Interfaces\Renderable;
use Argentum88\Phad\Interfaces\FormItemInterface;
use Phalcon\DI;

abstract class BaseFormItem implements Renderable, FormItemInterface
{

    protected $di;

    protected $view;
    protected $instance;
    protected $validation;
    protected $validationRules = [];

    public function __construct()
    {
        $this->di = DI::getDefault();
    }

    public function initialize()
    {
    }

    public function setInstance($instance)
    {
        return $this->instance($instance);
    }

    public function validation($validation = null)
    {
        if (is_null($validation))
        {
            return $this->validation;
        }
        $this->validation = $validation;
        return $this;
    }

    public function instance($instance = null)
    {
        if (is_null($instance))
        {
            return $this->instance;
        }
        $this->instance = $instance;
        return $this;
    }

    public function validationRules($validationRules = null)
    {
        if (is_null($validationRules))
        {
            return $this->validationRules;
        }
        $this->validationRules = $validationRules;
        return $this;
    }

    public function getValidationRules()
    {
        return $this->validationRules();
    }

    public function validationRule($rule)
    {
        $this->validationRules[] = $rule;
        return $this;
    }

    public function save()
    {
    }

    public function getParams()
    {
        return [
            'instance'   => $this->instance(),
            'validation' => $this->validation()
        ];
    }

    public function render()
    {
        $params = $this->getParams();
        return $this->di->get('viewSimple')->render('Formitem/' . $this->view, $params);
    }

    function __toString()
    {
        return (string)$this->render();
    }

} 