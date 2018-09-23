<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

final class TokenAuthenticatedGithubRequestBuilderFactory implements GithubRequestBuilderFactory
{
    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @var string
     */
    private $baseUrl;

    public function __construct(RequestFactoryInterface $requestFactory, UriFactoryInterface $uriFactory, string $baseUrl)
    {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->baseUrl = $baseUrl;
    }

    public function create(string $token): GithubRequestBuilder
    {
        return new TokenAuthenticatedGithubRequestBuilder(
            $this->requestFactory,
            $this->uriFactory,
            $this->baseUrl,
            $token
        );
    }
}
