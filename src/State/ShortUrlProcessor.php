<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShortUrlProcessor implements ProcessorInterface
{
    private $client;
    public function __construct(private ProcessorInterface $persistProcessor, private ProcessorInterface $removeProcessor, HttpClientInterface $client)
    {
        $this->client = $client;
    }
        
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $url = $data->getUrl();

        $response = $this->client->request('GET', 'https://tinyurl.com/api-create.php', [
            'query' => [
                'url' => $url,
            ],
        ]);

        $data->setUrl($response->getContent());
        
        $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
