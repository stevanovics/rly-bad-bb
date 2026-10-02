<?php

declare(strict_types=1);

namespace RlyBadBB\Core\Http;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Adapter for PSR-7 ServerRequestInterface.
 */
class Request
{
    /**
    * Construct the request.
    *
    * @param ServerRequestInterface $request PSR-7 server request.
    */
    public function __construct(private ServerRequestInterface $request)
    {
    }

    /**
     * Construct request from superglobals.
     *
     * @return self Request consturcted from superglobals.
     */
    public static function fromGlobals(): self
    {
        $factory = new Psr17Factory();
        $creator = new ServerRequestCreator($factory, $factory, $factory, $factory);

        return new self($creator->fromGlobals());
    }

    /**
     * Retreives the HTTP method of the request.
     *
     * @return string HTTP method of the request.
     */
    public function method(): string
    {
        return $this->request->getMethod();
    }

    /**
     * Retreives the path component of the request URI.
     *
     * @return string The URI path.
     */
    public function path(): string
    {
        return $this->request->getUri()->getPath();
    }
}
