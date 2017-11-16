<?php

namespace Kprovorov\DocScribe;

class MarkdownProvider
{
    const SUBFOLDER_NAME = 'docs';

    protected $category;

    protected $routes;

    protected $text;

    protected $path;

    protected $filename;

    public function __construct($category)
    {
        $this->category = $category;
        $this->setPath();
        $this->setFilename();
    }

    public function save()
    {
        if ($this->routes) {
            foreach ($this->routes as $route) {
                $this->text .= $this->composeText($route);
                $this->text .= "\r\n\r\n";
            }

            if (!file_exists($this->path)) {
                mkdir($this->path);
            }

            file_put_contents($this->getFilePath(), $this->text);
        }

        $this->clear();
    }

    public function clear()
    {
        $category = null;
        $routes = null;
        $text = null;
        $path = null;
        $filename = null;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename = null)
    {
        if ($filename) {
            $this->filename = $filename;
        } else {
            $this->filename = "{$this->category}.md";
        }
    }

    protected function getFilePath()
    {
        return "{$this->path}/{$this->filename}";
    }

    public function setPath($path = null)
    {
        if ($path) {
            $this->path = $path;
        } else {

            if (isset($GLOBALS['DOCSCRIBE_SUBFOLDER'])) {
                $this->path = getcwd() . '/' . $GLOBALS['DOCSCRIBE_SUBFOLDER'];
            } else {
                $this->path = getcwd() . '/' . self::SUBFOLDER_NAME;
            }
        }
    }

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    protected function composeText(Route $route)
    {
        return "###{$route->getTitle()}\r\n{$route->getDescription()}\r\n\r\nURL:\r\n`{$route->getMethod()}: {$route->getUri()}`\r\n\r\nRequest:\r\n```json\r\n{$route->getRequest()}\r\n```\r\n\r\nResponse:\r\n```json\r\n{$route->getResponse()}\r\n```";
    }
}