<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;

final class TokenAuthenticatedGithubRequestBuilder implements GithubRequestBuilder
{
    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        string $baseUriString,
        string $token
    ) {
        $this->requestFactory = $requestFactory;
        $this->uri = $uriFactory->createUri($baseUriString);
        $this->token = $token;
        $this->method = RequestMethodInterface::METHOD_GET;
    }

    public function withPath(string $path): GithubRequestBuilder
    {
        $this->uri = $this->uri->withPath($path);

        return $this;
    }

    public function withMethod(string $method): GithubRequestBuilder
    {
        $this->method = $method;

        return $this;
    }

    public function get(): RequestInterface
    {
        $request = $this->requestFactory->createRequest(
            $this->method,
            $this->uri
        );

        return $request->withHeader('Authorization', 'token ' . $this->token);
    }
}
