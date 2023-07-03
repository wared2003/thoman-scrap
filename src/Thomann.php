<?php

declare(strict_types=1);

namespace Wared2003\ThomannScrap;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use http\Client\Response;
use mysql_xdevapi\Exception;
use Psr\Http\Message\ResponseInterface;
use Wared2003\ThomannScrap\models\Category;

class Thomann
{
    private string $baseUrl = "https://www.thomann.de";
    private Client $httpClient;
    /**
     * Thomann constructor.
     * @param string $lang LANGUAGE CODE TO GET CONTENTS IN THAT LANGUAGE
     */
    public function __construct(string $lang = "en")
    {
        $this->baseUrl = $this->baseUrl . "/" . $lang . "/";
        $this->httpClient = new Client();
    }

    /**
     * @return Category[]
     */
    public function getCategorys(): array
    {
        $html = "";
        $elements = [];
        try {
            $res = $this->httpClient->request('GET', $this->baseUrl . 'cat.html');
            $html = (string) $res->getBody();
        } catch (GuzzleException $e) {
            return [];
        }
            $doc = new DOMDocument();
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $categorys = $xpath->evaluate("//div[@class='category']");
        try {
            /* @phpstan-ignore-next-line */
            foreach ($categorys as $category) {
                $texts = [];
                /* @phpstan-ignore-next-line */
                foreach (explode("\n", $category->textContent) as $el) {
                    if (trim($el) != "" && preg_match("/\w/", trim($el))) {
                        array_push($texts, ltrim($el));
                    }
                }
                $parent = ltrim($texts[0]);
                unset($texts[0], $texts[1]);
                foreach ($texts as $cat) {
                    /* @phpstan-ignore-next-line */
                    $elements[] = new models\Category($cat, preg_replace('/\s+/', '_', $cat), $parent);
                }
            }
            return $elements;
        } catch (Exception $e) {
            return [];
        }
    }
}
