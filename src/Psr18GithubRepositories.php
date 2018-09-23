<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriFactoryInterface;

final class Psr18GithubRepositories implements GithubRepositories
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var GithubRequestBuilderFactory
     */
    private $requestBuilderFactory;

    /**
     * @var string
     */
    private $token;

    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    public function __construct(
        ClientInterface $client,
        GithubRequestBuilderFactory $requestBuilderFactory,
        UriFactoryInterface $uriFactory,
        string $token
    ) {
        $this->client = $client;
        $this->requestBuilderFactory = $requestBuilderFactory;
        $this->token = $token;
        $this->uriFactory = $uriFactory;
    }

    public function forOwner(): array
    {
        $request = $this->requestBuilderFactory->create($this->token)
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('/user/repos')
            ->get();

        $response = $this->client->sendRequest($request);

        $responsePayload = json_decode((string) $response->getBody(), true);

        return array_map(function (array $payload) {
            return new Repository(
                $payload['owner']['login'],
                $payload['name'],
                $this->uriFactory->createUri($payload['url']),
                $payload['description']
            );
        }, $responsePayload);
    }
}
