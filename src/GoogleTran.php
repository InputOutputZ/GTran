<?php

namespace GoogleTran\Translate;

use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

use GoogleTran\Translate\GoogleTranHelpers;

class GoogleTran extends GoogleTranHelpers { 

	protected $key;
	protected $http;
	protected $host;
	protected $detectpath;
	protected $transpath;
	protected $languagepath;

	public function __construct($key, $host, $detectpath, $transpath, $languagepath){
		$this->key = $key;
		$this->detectpath = $detectpath;
		$this->languagepath = $languagepath;
		$this->host = $host;
		$this->transpath = $transpath;
		$this->http = $this->setupClient();
	}

	public function setupClient(){
		$headers = collect(['Content-Type' => 'application/json; charset=UTF-8',
							'Accept' => 'application/json',
							'charset' => 'utf-8']);
		return new Client(['headers' => $headers->toArray(),'base_uri' => $this->host]);
	}


	public function translateText($query,$target,$source,$format,$model,$concat = false){

		$text_segments = explode(",",$query);

		if(count($text_segments) > 1){
			foreach($text_segments as $key => $segment){
				if($concat){
					$text_segments[$key] = $concat.iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
				}else {
					$text_segments[$key] = iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
				}
			}
		}else {
			if($concat){
				$text_segments = [$concat.iconv(mb_detect_encoding($query, mb_detect_order(), true), "UTF-8", $query)];
			}else {
				$text_segments = [iconv(mb_detect_encoding($query, mb_detect_order(), true), "UTF-8", $query)];
			}
		}

		$body = [
	       'json' => array('q' => $text_segments,
	   						'model' => $model,
	   						'target' => $target,
	   						'source' => $source,
	   						'format' => $format)
		];	

		$this->http = $this->setupClient();

		$response = $this->http->post($this->transpath."?key=".$this->key, $body);

	    $responseBody = $response->getBody();
	    $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);

	    return $decodedBodyJson;
	}

	public function detectTextInformation($query)
	{

		$text_segments = explode(",",$query);

		if(count($text_segments) > 1){
			foreach($text_segments as $key => $segment){
				$text_segments[$key] = iconv(mb_detect_encoding($segment, mb_detect_order(), true), "UTF-8", $segment);
			}
		}else {
			$text_segments = [iconv(mb_detect_encoding($query, mb_detect_order(), true), "UTF-8", $query)];
		}

		$body = [
	       'json' => array('q' => $text_segments)
		];	

		$this->http = $this->setupClient();
		$response = $this->http->post($this->detectpath."?key=".$this->key, $body);

	    $responseBody = $response->getBody();
	    $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);

	    return $decodedBodyJson;

	}

	public function translationsAvailable($model,$locale){
		$this->http = $this->setupClient();
		$response = $this->http->get($this->languagepath."?model=".$model."&target=".$locale."&key=".$this->key);
	    $responseBody = $response->getBody();
	    $decodedBodyJson = json_decode($responseBody, JSON_UNESCAPED_UNICODE);
	    return $decodedBodyJson;

	}

}