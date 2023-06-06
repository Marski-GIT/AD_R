<?php

declare(strict_types=1);

namespace adRespect\Controllers;

class AbstractController
{
    protected string $action;
    private string $defaultAction = 'home';

    /**
     * @description Defining an action method.
     * @return string
     */
    protected function defineMethod(): string
    {
        $method = $this->action;
        if (!method_exists($this, $method)) {
            $method = $this->defaultAction;
        }
        return $method;
    }
}
