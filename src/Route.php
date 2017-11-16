<?php

namespace Kprovorov\DocScribe;

class Route
{
    protected $title;

    protected $description;

    protected $method;

    protected $uri;

    protected $request;

    protected $response;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $this->formatJson($request);

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $this->formatJson($response);;

        return $this;
    }

    protected function formatJson($json)
    {
        return json_encode(json_decode($json, true), JSON_PRETTY_PRINT);
    }
}