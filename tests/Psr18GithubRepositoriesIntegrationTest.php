<?php

namespace Sip\HttpPsrsDemo\Tests;

use Http\Adapter\Guzzle6\Client;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\UriFactory;
use PHPUnit\Framework\TestCase;
use Sip\HttpPsrsDemo\Psr18GithubRepositories;
use Sip\HttpPsrsDemo\TokenAuthenticatedGithubRequestBuilderFactory;

class Psr18GithubRepositoriesIntegrationTest extends TestCase
{
    /**
     * @var Psr18GithubRepositories
     */
    private $repositories;

    public function setUp()
    {
        $uriFactory = new UriFactory();

        $token = getenv('GITHUB_TOKEN');
        $url = getenv('GITHUB_URL');

        if (!getenv('GITHUB_TESTS_ENABLED')) {
            $this->markTestSkipped("Github tests disabled");
        }

        assert($token !== false, 'Set up required GITHUB_TOKEN env variable');

        $this->repositories = new Psr18GithubRepositories(
            new Client(new \GuzzleHttp\Client()),
            new TokenAuthenticatedGithubRequestBuilderFactory(
                new RequestFactory(),
                $uriFactory,
                $url !== false ? $url : 'https://api.github.com'
            ),
            $uriFactory,
            $token
        );
    }

    public function testForOwner()
    {
        $repositories = $this->repositories->forOwner();

        $this->assertNotEmpty($repositories);
    }
}
