<?php

namespace Nilixin\Edu;

use Nilixin\Edu\exception\ViewNotFoundException;

class ViewHandler
{
    public function __construct(
        protected string $view,
        protected array $params = [])
    { }

    public function __toString()
    {
        return $this->render();
    }

    public static function make(string $view, array $params = [])
    {
        return new static($view, $params);
    }

    public function render()
    {
        if (! file_exists($this->view)) {
            throw new ViewNotFoundException();
        }

        extract($this->params);

        ob_start();

        include $this->view;

        return (string) ob_get_clean();
    }
}