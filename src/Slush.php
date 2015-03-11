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
 * Represents the Slush mining pool.
 */
class Slush extends SimpleAccountType implements Miner {

  public function getName() {
    return "Slush's pool";
  }

  public function getCode() {
    return "slush";
  }

  public function getURL() {
    return "https://mining.bitcoin.cz/";
  }

  public function getFields() {
    return array(
      // not sure what the format is, but it looks to be [user-id]-[random 32 hex characters]
      'api_token' => array(
        'title' => "API current token",
        'regexp' => "#^[0-9]+-[0-9a-f]{32}$#",
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

    $url = "https://mining.bitcoin.cz/accounts/profile/json/" . $account['api_token'];
    $logger->info($url);

    try {
      $raw = Fetch::get($url);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }
    $json = Fetch::jsonDecode($raw);

    if (!$json) {
      throw new AccountFetchException($raw);
    }

    return array(
      'btc' => array(
        'confirmed' => $json['confirmed_reward'],
        'unconfirmed' => $json['unconfirmed_reward'],
        'estimated' => $json['estimated_reward'],
        'hashrate' => $json['hashrate'],
      ),
      'nmc' => array(
        'confirmed' => $json['confirmed_nmc_reward'],
        'unconfirmed' => $json['unconfirmed_nmc_reward'],
        'hashrate' => $json['hashrate'],
      ),
    );

  }

}
