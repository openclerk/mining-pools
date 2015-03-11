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

/**
 * Many mining pools are using php-mpos mining pool software.
 */
abstract class AbstractMPOSAccount extends SimpleAccountType implements Miner {

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
  public function fetchSupportedHashrateCurrencies(Logger $logger) {
    return $this->fetchSupportedCurrencies($logger);
  }

  /**
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, Logger $logger) {

    $balance = $this->fetchMPOSBalance($account, $logger);
    $status = $this->fetchMPOSStatus($account, $logger);

    $result = array();
    foreach ($this->fetchSupportedCurrencies($logger) as $cur) {
      if (!isset($result[$cur])) {
        $result[$cur] = array();
      }
      $result[$cur]['confirmed'] = $balance['confirmed'];
      $result[$cur]['unconfirmed'] = $balance['unconfirmed'];
      $result[$cur]['orphaned'] = $balance['orphaned'];
    }

    foreach ($this->fetchSupportedHashrateCurrencies($logger) as $cur) {
      if (!isset($result[$cur])) {
        $result[$cur] = array();
      }
      $result[$cur]['hashrate'] = $status['hashrate'];
      $result[$cur]['sharerate'] = $status['sharerate'];
    }

    return $result;

  }

  /**
   * Call API getuserbalance
   */
  function fetchMPOSBalance($account, Logger $logger) {

    $url = $this->getBaseAPI() . "action=getuserbalance&api_key=" . $account['api_key'];
    $logger->info($url);

    try {
      $this->throttle($logger);
      $raw = Fetch::get($url);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }

    try {
      $json = Fetch::jsonDecode($raw);
    } catch (FetchException $e) {
      throw new AccountFetchException($raw, $e);
    }

    return isset($json['getuserbalance']['data']) ? $json['getuserbalance']['data'] : $json['getuserbalance'];

  }

  /**
   * Call API getuserstatus
   */
  function fetchMPOSStatus($account, Logger $logger) {

    $url = $this->getBaseAPI() . "action=getuserstatus&api_key=" . $account['api_key'];
    $logger->info($url);

    try {
      $this->throttle($logger);
      $raw = Fetch::get($url);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }

    try {
      $json = Fetch::jsonDecode($raw);
    } catch (FetchException $e) {
      throw new AccountFetchException($raw, $e);
    }

    return isset($json['getuserstatus']['data']) ? $json['getuserstatus']['data'] : $json['getuserstatus'];
  }

}
