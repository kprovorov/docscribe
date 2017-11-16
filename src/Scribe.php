<?php

namespace Kprovorov\DocScribe;

class Scribe
{
    protected $classname;

    /**
     * @var MarkdownProvider
     */
    protected $provider;

    public function create($classname)
    {
        $this->classname = $classname;

        $this->provider = new MarkdownProvider($this->getCategory());

        return $this;
    }

    public function addRoute($route)
    {
        $this->provider->addRoute($route);

        return $this;
    }

    public function save()
    {
        $this->provider->save();
        $this->clear();
    }

    protected function getCategory()
    {
        return str_replace('Test','',array_last(explode('\\', $this->classname)));
    }

    protected function clear()
    {
        $classname = null;
        $provider = null;
    }
}