<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

use Psr\Http\Message\RequestInterface;

interface GithubRequestBuilder
{
    public function withPath(string $path): self;
    public function withMethod(string $method): self;

    public function get(): RequestInterface;
}