<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\Account;
use \Account\Miner;
use \Account\DisabledAccount;
use \Account\SimpleAccountType;
use \Account\AccountFetchException;
use \Apis\FetchHttpException;
use \Apis\Fetch;

/**
 * Represents the BitMinter mining pool.
 */
class BitMinter extends SimpleAccountType implements Miner {

  public function getName() {
    return "BitMinter";
  }

  public function getCode() {
    return "bitminter";
  }

  public function getURL() {
    return "https://bitminter.com/";
  }

  public function getFields() {
    return array(
      // not sure what the format is, but it looks to be [user-id]-[random 32 hex characters]
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[A-Z0-9]{32}$#"
      ),
    );
  }

  /**
   * Get a list of all the currencies supported by this account (e.g. "btc", "ltc", ...).
   * Uses currency codes from openclerk/currencies.
   * May block.
   */
  public function fetchSupportedCurrencies(Logger $logger) {
    return array('btc', 'nmc');
  }

  /**
   * Get a list of all currencies that can return current hashrates.
   * This is not always strictly identical to all currencies that can be hashed;
   * for example, exchanges may trade in {@link HashableCurrency}s, but not actually
   * support mining.
   * May block.
   */
  public function fetchSupportedHashrateCurrencies(Logger $logger) {
    return array('btc', 'nmc');
  }

  /**
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, Logger $logger) {

    $url = "https://bitminter.com/api/users";
    $logger->info($url);
    $options = array(
      CURLOPT_HTTPHEADER => array("Authorization: key=" . $account['api_key']),
    );

    try {
      $raw = Fetch::get($url, $options);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }
    if ($raw === "Access denied") {
      throw new AccountFetchException("Access denied");
    }

    if (!$raw) {
      throw new AccountFetchException("Empty response: Have you enabled the API perk?");
    }

    $json = Fetch::jsonDecode($raw);
    if (isset($json['message'])) {
      throw new AccountFetchException($json['message']);
    }

    return array(
      'btc' => array(
        'confirmed' => isset($json['balances']['BTC']) ? $json['balances']['BTC'] : 0,
        'hashrate' => $json['hash_rate'],
        'workers' => $json['active_workers'],
      ),
      'nmc' => array(
        'confirmed' => isset($json['balances']['NMC']) ? $json['balances']['NMC'] : 0,
        'hashrate' => $json['hash_rate'],
        'workers' => $json['active_workers'],
      ),
    );

  }

}
