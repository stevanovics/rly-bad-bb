<?php

declare(strict_types=1);

namespace RlyBadBB\Http;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

/**
 * Wrapper class around ResponseInterfaceFactory to simplify
 * ResponseInterface creation and emitting of responses.
 */
class Response
{
    /**
     * Construct a HTTP response.
     *
     * @param ResponseInterface $response PSR-7 Response.
     */
    public function __construct(private ResponseInterface $response)
    {
    }

    /**
     *  Create a standard text/html response. Overwrites Content-Type
     *  header to always be text/html.
     *
     *  @param string $body Reponse body.
     *  @param int $code Response code.
     *  @param array<string, string> $headers Response headers.
     */
    public static function html(
        string $body = '',
        int $code = 200,
        array $headers = [],
    ): self {
        $psr17factory = new Psr17Factory();
        $responseBody = $psr17factory->createStream($body);
        $response = $psr17factory->createResponse($code)
            ->withBody($responseBody)
            ->withHeader('Content-Type', 'text/html');

        if (! empty($headers)) {
            foreach ($headers as $name => $value) {
                $response = $response->withHeader($name, $value);
            }
        }

        return new self($response);
    }

    /**
     * Construct a generic 500 error response.
     *
     * @param array<string, string> $headers Request headers.
     */
    public static function genericServerError(array $headers = []): self
    {
        return self::html('An error has occurred.', 500, $headers);
    }

    /**
     * Construct a 404 response.
     *
     * @param array<string, string> $headers Request headers.
     *
     * @return self Constructed response.
     */
    public static function notFound(array $headers = []): self
    {
        return self::html('Not found', 404, $headers);
    }

    /**
     * Returns wrapped ResponseInterface to be consumed by a PSR-7 compatible SapiEmitter.
     * Not to be used inside of business logic.
     */
    public function toPsr7(): ResponseInterface
    {
        return $this->response;
    }
}
