<?php

namespace Nilixin\Edu;

use Exception;
use Nilixin\Edu\exception\ViewNotFoundException;
use Nilixin\Edu\debug\Debug;

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

    public function layout(string $layoutFile)
    {
        if (! file_exists($this->view) || ! file_exists($layoutFile)) {
            throw new ViewNotFoundException();
        }

        extract($this->params);

        ob_start();
        
        // поиск переменных в файле разметки
        $layoutContents = file_get_contents($layoutFile);
        preg_match_all("/[{{]+\s+[A-Za-z]*\s+[}}]+/", $layoutContents, $layoutMatches);

        // поиск переменных в файле представления
        $viewContents = file_get_contents($this->view);
        preg_match_all("/[{{]+\s+[\S][A-Za-z]*\s+[}}]+/", $viewContents, $viewMatches);

        // очистка скобок до переменных
        foreach ($layoutMatches[0] as $key => $match) {
            $layoutMatches[0]["$key"] = preg_replace("/[{}\s]*/", "", $match);
        }
        foreach ($viewMatches[0] as $key => $match) {
            $viewMatches[0]["$key"] = preg_replace("/[{}\s]*/", "", $match);
        }

        // проверки на соответствие переменных и на их закрытие
        foreach ($layoutMatches[0] as $match) {
            if (! in_array($match, $viewMatches[0])) {
                throw new Exception("Not enough variables");
            }
            else {
                if (! in_array("/$match", $viewMatches[0])) {
                    throw new Exception("Variable blocks aren't closed");
                }
            }
        }

        // удаление закрывающих тегов из viewMatches[0]
        foreach ($viewMatches[0] as $key => $match) {
            if (str_contains($match, "/")) {
                unset($viewMatches[0][$key]);
            }
        }

        // сохранение блоков, которыми будут заменяться переменные
        $substringKey = 0;
        foreach ($viewMatches[0] as $key => $match) {
            if (! str_contains($match, "/")) {
                $substrings[$substringKey] = $this->getStringBetween($viewContents, "{{ $match }}", "{{ /$match }}");
                $substringKey++;
            }
        }

        // замена переменных сохранёнными блоками
        foreach ($layoutMatches[0] as $key => $match) {
            $layoutContents = str_replace("{{ $match }}", $substrings[$key], $layoutContents);
        }

        // TODO output buffer всё ещё работает или нет?
        echo $layoutContents;

        return (string) ob_get_clean();
    }

    function getStringBetween($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }
}