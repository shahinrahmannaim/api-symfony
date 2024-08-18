<?php




namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiServices
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchData(string $endpoint, array $params = []): array
    {
        try {
            $response = $this->httpClient->request('GET', $endpoint, [
                'query' => $params,
                'headers' => [
                    'Accept' => 'application/json',
                    // Add authorization or other headers if needed
                ]
            ]);

            return $response->toArray();
        } catch (\Exception $e) {
            // Log the error or handle it accordingly
            return ['error' => $e->getMessage()];
        }
    }
}

