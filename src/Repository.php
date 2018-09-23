<?php

declare(strict_types=1);

namespace Sip\HttpPsrsDemo;

use Psr\Http\Message\UriInterface;

final class Repository
{
    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $name;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @var string|null
     */
    private $description;

    public function __construct(string $owner, string $name, UriInterface $uri, ?string $description)
    {
        $this->owner = $owner;
        $this->name = $name;
        $this->uri = $uri;
        $this->description = $description;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUri(): UriInterface
    {
        return $this->uri;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
