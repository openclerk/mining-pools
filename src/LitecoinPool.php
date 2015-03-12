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
 * Represents the litecoinpool.org mining pool.
 */
class LitecoinPool extends SimpleAccountType implements Miner {

  public function getName() {
    return "litecoinpool.org";
  }

  public function getCode() {
    return "litecoinpool";
  }

  public function getURL() {
    return "https://www.litecoinpool.org/";
  }

  public function getFields() {
    return array(
      // looks like a 32 character hex string
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[a-f0-9]{32}$#"
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

    $url = "https://www.litecoinpool.org/api?api_key=" . $account['api_key'];
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

    return array(
      'ltc' => array(
        'confirmed' => $json['user']['unpaid_rewards'],
        'paid' => $json['user']['paid_rewards'],
        'total' => $json['user']['total_rewards'],
        'hashrate' => $json['user']['hash_rate'] * 1e3 /* KHash -> Hash */,
        'workers' => count($json['workers']),
      ),
    );

  }

}
