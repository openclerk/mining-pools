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
 * Represents the BTC Guild mining pool.
 */
class BTCGuild extends SimpleAccountType implements Miner {

  public function getName() {
    return "BTC Guild";
  }

  public function getCode() {
    return "btcguild";
  }

  public function getURL() {
    return "https://www.btcguild.com/";
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

  /**
   * Get a list of all the currencies supported by this account (e.g. "btc", "ltc", ...).
   * Uses currency codes from openclerk/currencies.
   * May block.
   */
  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc', 'nmc');
  }

  /**
   * Get a list of all currencies that can return current hashrates.
   * This is not always strictly identical to all currencies that can be hashed;
   * for example, exchanges may trade in {@link HashableCurrency}s, but not actually
   * support mining.
   * May block.
   */
  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc', 'nmc');
  }

  /**
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = "https://www.btcguild.com/api.php?api_key=" . $account['api_key'];
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

    $workers = count($json['workers']);
    $hashrate = 0;
    foreach ($json['workers'] as $worker) {
      $hashrate += $worker['hash_rate'];
    }

    return array(
      'btc' => array(
        'confirmed' => $json['user']['unpaid_rewards'],
        'total' => $json['user']['total_rewards'],
        'paid' => $json['user']['paid_rewards'],
        '24h' => $json['user']['past_24h_rewards'],
        'hashrate' => $hashrate,
        'workers' => $workers,
      ),
      'nmc' => array(
        'confirmed' => $json['user']['unpaid_rewards_nmc'],
        'total' => $json['user']['total_rewards_nmc'],
        'paid' => $json['user']['paid_rewards_nmc'],
        '24h' => $json['user']['past_24h_rewards_nmc'],
        'hashrate' => $hashrate,
        'workers' => $workers,
      ),
    );

  }

}
