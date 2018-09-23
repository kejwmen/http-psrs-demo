<?php
declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

use Fig\Http\Message\RequestMethodInterface;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\UriFactory;
use PHPUnit\Framework\TestCase;

class TokenAuthenticatedGithubRequestBuilderTest extends TestCase
{
    private const EXAMPLE_BASE_URI = 'https://example.com';
    private const EXAMPLE_TOKEN = 'foo';

    /**
     * @var TokenAuthenticatedGithubRequestBuilder
     */
    private $builder;

    public function setUp()
    {
        $this->builder = new TokenAuthenticatedGithubRequestBuilder(
            new RequestFactory(),
            new UriFactory(),
            self::EXAMPLE_BASE_URI,
            self::EXAMPLE_TOKEN
        );
    }

    public function testAppliesBaseUri(): void
    {
        $result = $this->builder->get();

        $this->assertSame(self::EXAMPLE_BASE_URI, (string) $result->getUri());
    }

    public function testAddsAuthorizationHeader(): void
    {
        $result = $this->builder->get();

        $authHeaders = $result->getHeader('Authorization');

        $this->assertCount(1, $authHeaders);
        $this->assertSame('token ' . self::EXAMPLE_TOKEN,$authHeaders[0]);
    }

    public function testWithPath()
    {
        $result = $this->builder
            ->withPath('/users')
            ->get();

        $this->assertSame('/users', $result->getUri()->getPath());
    }

    public function testWithMethod()
    {
        $result = $this->builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->get();

        $this->assertSame(RequestMethodInterface::METHOD_POST, $result->getMethod());
    }
}
