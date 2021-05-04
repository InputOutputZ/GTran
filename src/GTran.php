<?php

namespace GTran\Translate;

use GuzzleHttp\Client;
use Throwable;

class GTran extends GTranHelpers
{

    protected $key;
    protected $http;
    protected $host;
    protected $detectpath;
    protected $transpath;
    protected $languagepath;

    public function __construct($key, $host, $detectpath, $transpath, $languagepath)
    {
        $this->key = $key;
        $this->detectpath = $detectpath;
        $this->languagepath = $languagepath;
        $this->host = $host;
        $this->transpath = $transpath;
        $this->http = $this->setupClient();
    }

    public function setupClient()
    {
        $headers = collect(['Content-Type' => 'application/json; charset=UTF-8',
            'Accept' => 'application/json',
            'charset' => 'utf-8']);

        return new Client(['headers' => $headers->toArray(), 'base_uri' => $this->host]);
    }

    public function translateTextWithoutConcat($queries, $target, $source, $format, $model)
    {

        if (count($queries) >= 1) {
            foreach($queries as $key => $segment) {
                $queries[$key] = iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
            }
        } else {
            $queries = iconv(mb_detect_encoding($queries, mb_detect_order(), true), "UTF-8", $queries);
        }

        $body = [
            'json' => array('q' => $queries,
                'model' => $model,
                'target' => $target,
                'source' => $source,
                'format' => $format)
        ];

        try {
            $this->http = $this->setupClient();

            $response = $this->http->post($this->transpath . "?key=" . $this->key, $body);

            $responseBody = $response->getBody();
            $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);

            if (is_array($decodedBodyJson) && array_key_exists('data', $decodedBodyJson) && array_key_exists('translations', $decodedBodyJson['data'])
                && sizeof($decodedBodyJson['data']['translations']) > 0 && array_key_exists('translatedText',$decodedBodyJson['data']['translations'][0])) {
                return $decodedBodyJson['data']['translations'];
            } else {
                // failed translation
                return false;
            }
        } catch (Throwable $e) {
            return ['fail' => true, 'exception' => $e];
        }

    }

    public function translateText($query, $target, $source, $format, $model, $concat = false, $concatType = false)
    {

        if ($concat) {
            $text_segments = explode($concatType, $query);
        } else {
            $text_segments = $query;
        }

        if ($concat && count($text_segments) > 1) {
            foreach($text_segments as $key => $segment) {
                if ($concat) {
                    $text_segments[$key] = $concat . iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
                } else {
                    $text_segments[$key] = iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
                }
            }
        } else {
            if ($concat) {
                $text_segments = $concat . iconv(mb_detect_encoding($query, mb_detect_order(), true), "UTF-8", $query);
            } else {
                $text_segments = iconv(mb_detect_encoding($query, mb_detect_order(), true), "UTF-8", $query);
            }
        }

        $body = [
            'json' => array('q' => $text_segments,
                'model' => $model,
                'target' => $target,
                'source' => $source,
                'format' => $format)
        ];

        try {
            $this->http = $this->setupClient();

            $response = $this->http->post($this->transpath . "?key=" . $this->key, $body);

            $responseBody = $response->getBody();
            $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);

            if (is_array($decodedBodyJson) && array_key_exists('data', $decodedBodyJson) && array_key_exists('translations', $decodedBodyJson['data'])
                && sizeof($decodedBodyJson['data']['translations']) > 0 && array_key_exists('translatedText',$decodedBodyJson['data']['translations'][0])) {
                return $decodedBodyJson['data']['translations'][0]['translatedText'];
            } else {
                // failed translation
                return false;
            }
        } catch (Throwable $e) {
            return ['fail' => true, 'exception' => $e];
        }
    }

    public function detectTextInformation($query, $concat = false, $concatType = false)
    {

        if ($concat) {
            $text_segments = explode($concatType, $query);
        } else {
            $text_segments = $query;
        }

        if ($concat && count($text_segments) > 1) {
            foreach($text_segments as $key => $segment) {
                $text_segments[$key] = iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
            }
        } else {
            $text_segments = [iconv(mb_detect_encoding($query, mb_detect_order(), true), "UTF-8", $query)];
        }

        $body = [
            'json' => array('q' => $text_segments)
        ];

        try {
            $this->http = $this->setupClient();
            $response = $this->http->post($this->detectpath . "?key=" . $this->key, $body);

            $responseBody = $response->getBody();
            $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);

            return $decodedBodyJson;
        } catch (Throwable $e) {
            return ['fail' => true, 'exception' => $e];
        }

    }

    public function translationsAvailable($model, $locale)
    {

        try {
            $this->http = $this->setupClient();
            $response = $this->http->get($this->languagepath . "?model=" . $model . "&target=" . $locale . "&key=" . $this->key);
            $responseBody = $response->getBody();
            $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);

            return $decodedBodyJson;
        } catch (Throwable $e) {
            return ['fail' => true, 'exception' => $e];
        }

    }

}