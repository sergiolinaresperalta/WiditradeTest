<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ShortUrlsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Post;
use App\State\ShortUrlProcessor;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ShortUrlsRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['read'],
    ],
    denormalizationContext: [
        'groups' => ['write'],
    ],
)]
#[Post(
    uriTemplate: '/v1/short-urls', 
    openapiContext: [
        'responses' => [
            '200' => [
                'description' => 'Short URL created',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'url' => [
                                    'type' => 'string',
                                    'format' => 'uri',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    processor: ShortUrlProcessor::class)]
class ShortUrls
{
    // hide Id in response body
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['write'])]
    private ?int $id = null;

    #[ORM\Column(length: 2000)]
    #[Groups(['read', 'write'])]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
