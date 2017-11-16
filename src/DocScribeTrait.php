<?php

namespace Kprovorov\DocScribe;

trait DocScribeTrait
{
    /**
     * @var Scribe
     */
    protected static $scribe;

    /**
     * @var boolean
     */
    protected $make_doc;

    /**
     * @var Route
     */
    protected $route;

    public function setUp()
    {
        $this->afterApplicationCreated(function() {
            $this->route = new Route;
        });

        $this->beforeApplicationDestroyed(function () {
            if ($this->make_doc) {
                self::$scribe->addRoute($this->route);
            }
        });

        parent::setUp();
    }

    public static function setUpBeforeClass()
    {
        self::$scribe = (new Scribe())->create(static::class);
    }

    public static function tearDownAfterClass()
    {
        self::$scribe->save();
        self::$scribe = null;
    }

    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $parameters
     * @param  array  $cookies
     * @param  array  $files
     * @param  array  $server
     * @param  string  $content
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
    {
        $this->route->setUri($uri)->setMethod($method)->setRequest(json_encode($parameters));

        return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
    }

    /**
     * Create the test response instance from the given response.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function createTestResponse($response)
    {
        $this->route->setResponse($response->content());

        return parent::createTestResponse($response);
    }

    public function doc($title, $description = null)
    {
        $this->route->setTitle($title)->setDescription($description);
        $this->make_doc = true;

        return $this;
    }
}