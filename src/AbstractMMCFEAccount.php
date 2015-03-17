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
 * Many mining pools are using mmcfe mining pool software.
 */
abstract class AbstractMMCFEAccount extends AbstractMiner {

  /**
   * Get the API URL for the given key.
   */
  abstract function getBaseAPI();

  /**
   * All MPOS accounts have the same API keys
   */
  public function getFields() {
    return array(
      // looks like a 64 character hex string
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[a-f0-9]{64}$#"
      ),
    );
  }

  /**
   * Assumes that all supported balance currencies also supports hashrates
   */
  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return $this->fetchSupportedCurrencies($factory, $logger);
  }

  /**
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = $this->getBaseAPI() . $account['api_key'];
    $json = $this->fetchJSON($url, $logger, 60 /* throttle to 60 seconds */);

    $result = array();
    foreach ($this->fetchSupportedCurrencies($factory, $logger) as $cur) {
      $result[$cur] = array(
        'confirmed' => $json['confirmed_rewards'],
        'estimated' => $json['round_estimate'],
        'total' => $json['payout_history'],
        'hashrate' => $json['total_hashrate'],
        'workers' => count($json['workers']),
      );
    }

    return $result;
  }

}
