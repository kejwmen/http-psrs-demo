<?php

namespace Sip\HttpPsrsDemo\Tests;

use Fig\Http\Message\RequestMethodInterface;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Http\Factory\Guzzle\StreamFactory;
use Http\Factory\Guzzle\UriFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Sip\HttpPsrsDemo\Psr18GithubRepositories;
use Sip\HttpPsrsDemo\Repository;

class Psr18GithubRepositoriesUnitTest extends TestCase
{
    /**
     * @var Psr18GithubRepositories
     */
    private $repositories;

    /**
     * @var ClientInterface|MockObject
     */
    private $client;

    /**
     * @var TestGithubRequestBuilderFactory
     */
    private $requestFactory;

    public function setUp()
    {
        $uriFactory = new UriFactory();

        $this->client = $this->createMock(ClientInterface::class);

        $this->requestFactory = new TestGithubRequestBuilderFactory();

        $this->repositories = new Psr18GithubRepositories(
            $this->client,
            $this->requestFactory,
            $uriFactory,
            'foo'
        );
    }

    public function testForOwner()
    {
        $this->willFetchListOfOwnerRepositoriesAndReturnPayload([
            [
                'name' => 'foo',
                'owner' => [
                    'login' => 'john_doe'
                ],
                'url' => 'http://example.com/foo',
                'description' => null
            ],
            [
                'name' => 'bar',
                'owner' => [
                    'login' => 'john_doe'
                ],
                'url' => 'http://example.com/bar',
                'description' => 'Lorem ipsum'
            ]
        ]);

        $repositories = $this->repositories->forOwner();

        $expected = [
            new Repository('john_doe', 'foo', new Uri('http://example.com/foo'), null),
            new Repository('john_doe', 'bar', new Uri('http://example.com/bar'), 'Lorem ipsum')
        ];

        $this->assertEquals($expected, $repositories);
    }

    private function willFetchListOfOwnerRepositoriesAndReturnPayload(array $payload): void
    {
        $request = $this->requestFactory->create('foo')
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('/user/repos')
            ->get();

        $this->client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn(new Response(
                StatusCodeInterface::STATUS_OK,
                [],
                (new StreamFactory())->createStream(json_encode($payload))
            ));
    }
}
