<?php

namespace Thurasn\TradeNet;

use GuzzleHttp\Client;
use Thurasn\TradeNet\Traits\TradeNetActionRequest;
use Thurasn\TradeNet\Traits\TradeNetRequestBody;


class TradeNet
{

  use TradeNetRequestBody, TradeNetActionRequest;

  protected $client;
  protected $serviceStatus;
  protected $token;
  protected $verify;
  protected $contentType;
  protected $productionURL;
  protected $uatURL;
  protected $OGADepartmentCode;
  protected $OGASectionCode;
  protected $username;
  protected $password;
  protected $grantType;

  private $endpoints = [
    'auth' => '/oauth/token', // No More Required (instead using OAuth-Token use => white-list-ip)
    'new' => '/api/OGA/New',
    'amend' => '/api/OGA/Amend',
    'extension' => '/api/OGA/Extension',
  ];


  public function __construct()
  {
    // Init 
    $this->serviceStatus = env('TRADENET_STATUS');
    $this->client = new Client;
    $this->contentType = 'application/json';
    $this->uatURL = env('TRADENET_UAT_URL', "https://testingapi.myanmartradenet.com");
    $this->productionURL = env('TRADENET_PROD_URL', "https://api.myanmartradenet.com");
    $this->OGADepartmentCode = env('OGA_DEPARTMENT_CODE');
    $this->OGASectionCode = env('OGA_SECTION_CODE');
    $this->username = env('TRADENET_USERNAME');
    $this->password = env('TRADENET_PASSWORD');
    $this->grantType = env('TRADENET_GRANTTYPE');
  }

  private function getApiURL(string $key): string
  {
    $baseUrl = env('APP_ENV') === 'production' ? $this->productionURL : $this->uatURL;
    return $baseUrl . $this->endpoints[$key];
  }

  //  New
  public static function newOgaProcessRequest($data)
  {
    $instance = new self();
    return $instance->ogaActionRequest($data, 'new');
  }

  // Amend
  public static function amendOgaProcessRequest($data)
  {
    $instance = new self();
    return $instance->ogaActionRequest($data, 'amend');
  }

  // Extend
  public static function extendOgaRequest($data)
  {
    $instance = new self();
    return $instance->ogaActionRequest($data, 'extend');
  }

  // Config
  public static function getConfig()
  {
    $instance = new self();
    return $instance->getConfiguration();
  }
}
