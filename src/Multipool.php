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
 * Represents the Multipool mining pool.
 */
class Multipool extends AbstractMiner {

  public function getName() {
    return "Multipool";
  }

  public function getCode() {
    return "multipool";
  }

  public function getURL() {
    return "https://www.multipool.us/";
  }

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
   * Convert the multiple-character currency code returned by Multipool
   * into the three-character openclerk/currencies code.
   * @return e.g. "dog" instead of "DOGE"
   */
  public function getCurrencyCode($cur) {
    switch (strtolower($cur)) {
      case "doge": return "dog";
      default: return strtolower($cur);
    }
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    // we emulate an API call by requesting a known API key
    $url = "http://api.multipool.us/api.php?api_key=674219722ba686793d427dbe16fc0e884bdf2cf9f43ebdd2fd22a84e2fd36c01";
    $json = $this->fetchJSON($url, $logger);

    $result = array();
    foreach ($json['currency'] as $cur => $ignored) {
      $currency = $this->getCurrencyCode($cur);

      if (strlen($currency) == 3) {
        $result[] = $currency;
      }
    }

    return $result;
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return $this->fetchSupportedCurrencies($factory, $logger);
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {
    $url = "http://api.multipool.us/api.php?api_key=" . $account['api_key'];
    $json = $this->fetchJSON($url, $logger);

    if (!count($json['currency'])) {
      throw new AccountFetchException("Invalid API key");
    }

    $result = array();
    foreach ($json['currency'] as $cur => $data) {
      $currency = $this->getCurrencyCode($cur);

      if (strlen($currency) == 3) {
        $result[$currency] = array(
          'confirmed' => $data['confirmed_rewards'],
          'estimated' => $data['estimated_rewards'],
          'paid' => $data['payout_history'],
          'hashrate' => $data['hashrate'] * 1e3 /* KH/s -> H/s */
        );
      }
    }

    return $result;
  }

}
