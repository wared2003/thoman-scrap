<?php
declare(strict_types = 1);
namespace Wared2003\ThomannScrap;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use http\Client\Response;
use mysql_xdevapi\Exception;
use Psr\Http\Message\ResponseInterface;

class Thomann
{
    private string $baseUrl = "https://www.thomann.de";
    private Client $httpClient;
    public function __construct(string $lang = "en")
    {
        $this->baseUrl = $this->baseUrl . "/" . $lang . "/";
        $this->httpClient = new Client();
    }

    /**
     * @return string[]
     */
    public function getCategorys(): array {
        try {
            $res = $this->httpClient->request('GET', $this->baseUrl);
            $html = $res->getBody()->getContents();
            return [$html];
        }catch (GuzzleException $e){
            echo $e->getMessage();
            return [];
        }

    }
}
