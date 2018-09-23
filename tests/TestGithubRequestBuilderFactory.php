<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo\Tests;

use Fig\Http\Message\RequestMethodInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Sip\HttpPsrsDemo\GithubRequestBuilder;
use Sip\HttpPsrsDemo\GithubRequestBuilderFactory;

final class TestGithubRequestBuilderFactory implements GithubRequestBuilderFactory
{
    public function create(string $token): GithubRequestBuilder
    {
        return new class('http://example.com') implements GithubRequestBuilder {
            /**
             * @var string
             */
            private $method = RequestMethodInterface::METHOD_GET;

            /**
             * @var string
             */
            private $path = '';

            /**
             * @var UriInterface
             */
            private $baseUri;

            public function __construct(string $baseUri)
            {
                $this->baseUri = new Uri($baseUri);
            }

            public function withPath(string $path): GithubRequestBuilder
            {
                $this->path = $path;

                return $this;
            }

            public function withMethod(string $method): GithubRequestBuilder
            {
                $this->method = $method;

                return $this;
            }

            public function get(): RequestInterface
            {
                return new Request(
                    $this->method,
                    $this->baseUri->withPath($this->path)
                );
            }
        };
    }
}
