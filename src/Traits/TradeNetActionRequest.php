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


  // OGA Action Request
  public function ogaActionRequest($data, $type)
  {
    switch ($type) {
      case 'new':
        $body = $this->buildNewOgaRequestBody($data);
        break;

      case 'amend':
        $body = $this->buildAmendOgaRequestBody($data);
        break;

      case 'extend':
        $body = $this->buildExtendOgaRequestBody($data);
        break;

      default:
        $body = null;
        break;
    }

    $response = $this->client->request('POST', $this->getApiURL($type), [
      'headers' => [
        'Content-Type' => $this->contentType
      ],
      'body' => $body
    ]);

    $responseData = json_decode($response->getBody()->getContents(), true);
    return $responseData;
  }

  // Get Configuration
  public function getConfiguration()
  {
    return [
      'service_status' => $this->serviceStatus,
      'content_type' => $this->contentType,
      'uat' => $this->uatURL,
      'production' => $this->productionURL,
      'department_code' => $this->OGADepartmentCode,
      'section_code' => $this->OGASectionCode,
      'username' => $this->username,
      'password' => $this->password,
      'grant_type' => $this->grantType,
    ];
  }
}
