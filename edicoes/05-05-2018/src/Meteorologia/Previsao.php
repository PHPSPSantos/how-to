<?php
/**
 *
 *  exemplo utilizando o Composer.
 *
 *  Faremos a revisão dessa solução nos próximos how-tos!
 *
 */


namespace Meteorologia; 

class Previsao
{
	private $weatherUrl;

	private $appId;

	public function __construct()
	{
		$this->weatherUrl = "http://api.openweathermap.org/data/2.5/weather";
		$this->appId      = "1073c253a0f5dfe954702b19462aeef3";
	}

	public function getPrevisao(array $data) : string
	{	
		$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', $this->weatherUrl, [
			'query' => [
				'appid' => $this->appId,
				'q'	    => $this->buildQuery($data)
			]
		]);
		return $res->getBody();
	}


	public function buildQuery(array $inputValues) : string
    {
        $parsedData = [];
        $allowedValues = ['cidade','estado','pais'];
        foreach ($allowedValues as $allowedValue) {
            if ($inputValues[$allowedValue]) {
                $parsedData[] = $inputValues[$allowedValue];
            }
        }
        return implode(",", $parsedData);
    }
}