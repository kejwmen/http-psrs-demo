<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

interface GithubRequestBuilderFactory
{
    public function create(string $token): GithubRequestBuilder;
}