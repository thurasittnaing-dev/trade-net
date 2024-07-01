<?php

namespace Thurasn\TradeNet\Traits;

trait TradeNetRequestBody
{
  private function buildOAuthRequestBody(): array
  {
    return [
      'username' => $this->username,
      'password' =>  $this->password,
      'grant_type' => $this->grantType
    ];
  }

  private function buildNewOgaRequestBody($data): string
  {
    return json_encode([
      'OGADepartmentCode' => $this->OGADepartmentCode,
      'OGASectionCode' =>  $this->OGASectionCode,
      'ReferenceNo' => null,
      'OfficeLetterNo' =>  $data['OfficeLetterNo'],
      'OfficeLetterDate' =>  $data['OfficeLetterDate'],
      'CompanyRegistrationNo' =>  $data['CompanyRegistrationNo'],
      'ValidDateFrom' =>  $data['ValidDateFrom'],
      'ValidDateTo' => $data['ValidDateTo'],
      'Allowance' =>  $data['Allowance'],
      'UsedOnce' => 1,
      'RecommendationPDFURL' => $data['RecommendationPDFURL'],
      'Terminate' => 1,
    ]);
  }

  private function buildAmendOgaRequestBody($data): string
  {
    return json_encode([
      'OGADepartmentCode' => $this->OGADepartmentCode,
      'OGASectionCode' =>  $this->OGASectionCode,
      'ReferenceNo' => $data['ReferenceNo'],
      'OfficeLetterNo' =>  $data['OfficeLetterNo'],
      'OfficeLetterDate' =>  $data['OfficeLetterDate'],
      'CompanyRegistrationNo' =>  $data['CompanyRegistrationNo'],
      'ValidDateFrom' =>  $data['ValidDateFrom'],
      'ValidDateTo' => $data['ValidDateTo'],
      'Allowance' =>  $data['Allowance'],
      'UsedOnce' => 1,
      'RecommendationPDFURL' => $data['RecommendationPDFURL'],
      'Terminate' => 1,
    ]);
  }

  private function buildExtendOgaRequestBody($data): string
  {
    return json_encode([
      'ReferenceNo' => $data['ReferenceNo'],
      'ValidDateFrom' =>  $data['ValidDateFrom'],
      'ValidDateTo' => $data['ValidDateTo'],
      'RecommendationPDFURL' => $data['RecommendationPDFURL'],
    ]);
  }
}
