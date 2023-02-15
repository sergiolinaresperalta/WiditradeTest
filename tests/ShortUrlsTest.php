<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ShortUrlsTest extends ApiTestCase
{

    public function testCreateShortUrlWithoutToken(): void
    {
        $client = static::createClient();

        $client->request('POST', 'api/v1/short-urls', [
            'json' => [
                'url' => 'https://www.google.com',
            ],
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testCreateShortUrlWithWrongBearerAuthorization(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            'api/v1/short-urls',
            [
                'json' => [
                    'url' => 'https://www.google.com',
                ],
                'headers' => ['Authorization' => 'Bearer [{)]'],
            ]
        );

        $this->assertResponseStatusCodeSame(403);
    }

    public function testCreateShortUrlWithBearerAuthorization(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            'api/v1/short-urls',
            [
                'json' => [
                    'url' => 'https://www.google.com',
                ],
                'headers' => ['Authorization' => 'Bearer {}'],
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/contexts/ShortUrls',
            '@type' => 'ShortUrls'
        ]);
    }

}