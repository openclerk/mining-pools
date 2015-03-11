<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\Account;
use \Account\Miner;
use \Account\DisabledAccount;
use \Account\SimpleAccountType;
use \Account\AccountFetchException;
use \Apis\FetchHttpException;
use \Apis\FetchException;
use \Apis\Fetch;
use \Openclerk\Currencies\CurrencyFactory;
use \Openclerk\Currencies\HashableCurrency;

/**
 * Represents the Eobot mining pool.
 */
class Eobot extends SimpleAccountType implements Miner {

  public function getName() {
    return "Eobot";
  }

  public function getCode() {
    return "eobot";
  }

  public function getURL() {
    return "https://www.eobot.com/";
  }

  public function getFields() {
    return array(
      'api_id' => array(
        'title' => "User ID",
        'regexp' => "#^[0-9]+$#",
      ),
    );
  }

  /**
   * Get a list of all the currencies supported by this account (e.g. "btc", "ltc", ...).
   * Uses currency codes from openclerk/currencies.
   * May block.
   */
  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    $url = "https://www.eobot.com/api.aspx?supportedcoins=true&json=true";
    $logger->info($url);

    try {
      $this->throttle($logger);
      $raw = Fetch::get($url);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }
    $json = Fetch::jsonDecode($raw);

    $result = array();
    foreach ($json as $cur => $data) {
      $currency = $this->getCurrencyCode($cur);
      $result[] = $currency;
    }

    return $result;
  }

  /**
   * Get a list of all currencies that can return current hashrates.
   * This is not always strictly identical to all currencies that can be hashed;
   * for example, exchanges may trade in {@link HashableCurrency}s, but not actually
   * support mining.
   * May block.
   */
  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return $this->fetchSupportedCurrencies($factory, $logger);
  }

  private function fetchJSON($url, Logger $logger) {
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

    if (!$json) {
      throw new AccountFetchException($raw);
    }

    return $json;
  }

  /**
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = "https://www.eobot.com/api.aspx?json=true&total=" . $account['api_id'];
    $total = $this->fetchJSON($url, $logger);

    $url = "https://www.eobot.com/api.aspx?json=true&idspeed=" . $account['api_id'];
    $speed = $this->fetchJSON($url, $logger);

    $url = "https://www.eobot.com/api.aspx?json=true&idmining=" . $account['api_id'];
    $mining = $this->fetchJSON($url, $logger);

    $result = array();
    foreach ($total as $cur => $balance) {
      if ($cur == "Total" || $cur == "GHS" || $cur == "SCRYPT" || $cur == "PPD") {
        continue;
      }

      $currency = $this->getCurrencyCode($cur);
      $result[$currency] = array('confirmed' => $balance);

      if ($mining['mining'] == $cur) {
        $result[$currency]['hashrate'] = $this->selectHashrate($factory, $currency, $speed);
      } else {
        $result[$currency]['hashrate'] = 0;
      }
    }

    return $result;
  }

  /**
   * Convert the multiple-character currency code returned by Eobot
   * into the three-character openclerk/currencies code.
   * @return e.g. "dog" instead of "DOGE"
   */
  public function getCurrencyCode($cur) {
    switch (strtolower($cur)) {
      case "doge": return "dog";
      case "sjcx": return "sj1";
      case "blk": return "bc1";
      default: return strtolower($cur);
    }
  }

  public function selectHashrate(CurrencyFactory $factory, $cur, $speed) {
    // find out the algorithm from CurrencyFactory
    $instance = $factory->loadCurrency($cur);
    $algorithm = "sha256";
    if ($instance != null && $instance instanceof HashableCurrency) {
      $algorithm = $instance->getAlgorithm();
    }

    switch ($algorithm) {
      case "scrypt":
        return $speed['MiningScrypt'];

      default:
        return $speed['MiningSHA-256'];
    }
  }

}
