<?php

namespace Thurasn\TradeNet\Traits;

use Illuminate\Support\Facades\Log;

trait TradeNetActionRequest
{
  public function getOAuthToken(): string
  {
    $body = $this->buildOAuthRequestBody();
    try {
      $response = $this->client->request('POST', $this->getApiURL('auth'), [
        'headers' => [
          'Content-Type' => $this->contentType,
        ],
        'form_params' => $body,
      ]);

      $responseData = json_decode($response->getBody()->getContents(), true);


      if (!array_key_exists('error', $responseData)) {
        return $this->setOAuthToken($responseData['access_token']);
      }

      return $this->setOAuthToken(null);
    } catch (\Exception $e) {
      // OAuth API Fail
      Log::error('tradenet-oauth-error' . json_encode($e->getMessage()));
      return $this->setOAuthToken(null);
    }
  }

  public function setOAuthToken($token): ?string
  {
    $this->token = $token;
    return $this->token;
  }

  public function newOGAProcess($data)
  {

    $this->getOAuthToken();
    if (is_null($this->token)) {
      return [
        'MessageType' => 'oauth-error'
      ];
    }

    $response = $this->client->request('POST', $this->getApiURL('new'), [
      'headers' => [
        'Content-Type' => $this->contentType,
        'Authen-Token' => "bearer $this->token"
      ],
      'body' => $this->buildNewOGARequestBody($data)
    ]);

    $responseData = json_decode($response->getBody()->getContents(), true);
    return $responseData;
  }

  public function extendOGAProcess($data)
  {
    $this->getOAuthToken();
    if (is_null($this->token)) {
      return [
        'MessageType' => 'oauth-error'
      ];
    }

    $response = $this->client->request('POST', $this->getApiURL('extension'), [
      'headers' => [
        'Content-Type' => $this->contentType,
        'Authen-Token' => "bearer $this->token"
      ],
      'body' => $this->buildExtendOGARequestBody($data)
    ]);

    $responseData = json_decode($response->getBody()->getContents(), true);
    return $responseData;
  }

  public function getConfiguration()
  {
    return [
      'service_status' => $this->serviceStatus,
      'content_type' => $this->contentType,
      'uat' => $this->uatURL,
      'production' => $this->productionURL,
      'department_code' => $this->OGADepartmentCode,
      'section_code' => $this->OGASectionCode,
      'username' => $this->TRADENET_USERNAME,
      'password' => $this->TRADENET_PASSWORD,
      'grant_type' => $this->grantType,
    ];
  }
}
