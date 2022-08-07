<?php

namespace Nilixin\Edu;

use Exception;
use Nilixin\Edu\exception\ViewNotFoundException;
use Nilixin\Edu\debug\Debug;

class ViewHandler
{
    public static $instance;
    private $product;
    
    private function __construct(
        protected string $view,
        protected array $variables = [],
        protected string $layout = "")
    { }

    public function __toString()
    {
        return $this->render();
    }



    public static function make(string $viewFile)
    {
        if (! file_exists($viewFile)) {
            throw new Exception("View file not found");
        }
        
        self::$instance = new static($viewFile);
        
        return self::$instance;
    }



    public function setVariables(array $variables = [])
    {
        if (empty($variables)) {
            throw new Exception("Variables array is empty");
        }

        $this->variables = $variables;

        return $this;
    }



    public function setLayout(string $layoutFile)
    {
        if (! file_exists($layoutFile)) {
            throw new Exception("Layout file not found");
        }

        $this->layout = $layoutFile;

        return $this;
    }



    public function render()
    {
        ob_start();

        $this->product = file_get_contents($this->view);

        if (! empty($this->layout)) {
            $this->product = $this->replaceInLayout();
        }

        if (! empty($this->variables)) {
            $this->product = $this->replaceVariables();
        }

        echo $this->product;

        return (string) ob_get_clean();
    }



    private function replaceInLayout()
    {
        // поиск переменных в файле разметки
        $layoutContents = file_get_contents($this->layout);
        preg_match_all("/[{][%]\s+[\S][A-Za-z]*\s+[%][}]/", $layoutContents, $layoutTags);

        // поиск переменных в файле представления
        $viewContents = file_get_contents($this->view);
        preg_match_all("/[{][%]\s+[\S][A-Za-z]*\s+[%][}]/", $viewContents, $viewTags);

        // проверка на соответствие переменных
        // исключение, если не найдено пар переменных в файлах разметки и представления
        foreach ($layoutTags[0] as $layoutTag) {
            $found = false;

            foreach ($viewTags[0] as $viewTag) {
                if ($layoutTag == $viewTag) {
                    $found = true;

                    break;
                }
            }

            if (! $found) {
                throw new Exception("Not enough tags or wrong formatting");
            }
        }

        // замена тегов и строки внутри них в файле разметки на контент внутри тегов в файле представления
        for ($i = 0; $i < count($layoutTags[0]); $i += 2) {
            $openingTag = $layoutTags[0][$i];
            $closingTag = $layoutTags[0][$i + 1];

            $oldString = $this->getStringBetween($layoutContents, $openingTag, $closingTag);
            $newString = $this->getStringBetween($viewContents, $openingTag, $closingTag);

            $layoutContents = str_replace($openingTag . $oldString . $closingTag, $newString, $layoutContents);
        }

        return $layoutContents;
    }



    private function replaceVariables()
    {
        $cleanProduct = $this->product;

        preg_match_all("/[{][{]\s+[\S][A-Za-z->]*\s+[}][}]/", $cleanProduct, $callableVariables);
        
        $cleanVariables = array();
        foreach ($callableVariables[0] as $callableVariable) {
            array_push($cleanVariables, preg_replace("/[{}\s]*/", "", $callableVariable));
        }

        // TODO не працюе
        extract($this->variables);
        Debug::val($user->login);
        
        foreach ($cleanVariables as $cleanVariable) {
            Debug::val($$cleanVariable);
        }

        

        // Debug::var($this->variables);
        // Debug::var($callableVariables[0]);

        // foreach ($this->variables as $key => $value) {
        //     if (! str_contains($cleanProduct, "{{ $key }}")) {
        //         Debug::val($key);
        //         // throw new Exception("Not enough variables or wrong formatting");
        //     }

        //     $cleanProduct = str_replace("{{ $key }}", $value, $cleanProduct);
        // }

        Debug::dd("STOP");

        return $cleanProduct;
    }



    private function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }


}