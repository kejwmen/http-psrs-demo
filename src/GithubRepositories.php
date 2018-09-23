<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

interface GithubRepositories
{
    /**
     * @return Repository[]
     */
    public function forOwner(): array;
}