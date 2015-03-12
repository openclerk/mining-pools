<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\Account;
use \Account\Miner;
use \Account\DisabledAccount;
use \Account\SimpleAccountType;
use \Account\AccountFetchException;
use \Apis\FetchException;
use \Apis\FetchHttpException;
use \Apis\Fetch;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the LiteGuardian mining pool.
 */
class LiteGuardian extends SimpleAccountType implements Miner {

  public function getName() {
    return "LiteGuardian";
  }

  public function getCode() {
    return "liteguardian";
  }

  public function getURL() {
    return "https://www.liteguardian.com/";
  }

  public function getFields() {
    return array(
      // looks like a 32 character hex string
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^api[a-f0-9]{32}$#"
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = "https://www.liteguardian.com/api/" . $account['api_key'];
    $logger->info($url);

    try {
      $this->throttle($logger, 15);
      $raw = Fetch::get($url);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }

    try {
      $json = Fetch::jsonDecode($raw);
    } catch (FetchException $e) {
      throw new AccountFetchException($raw, $e);
    }

    // was this an invalid key?
    if (isset($json['pool_name'])) {
      throw new AccountFetchException("Invalid API key");
    }

    return array(
      'ltc' => array(
        'confirmed' => $json['balance'],
        'paid' => $json['total_paid'],
        'hashrate' => $json['hashrate'] * 1e3 /* KHash -> Hash */,
        'workers' => count($json['workers']),
      ),
    );

  }

}
