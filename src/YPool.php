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
 * Represents the ypool.net mining pool.
 */
class YPool extends AbstractMiner {

  public function getName() {
    return "ypool.net";
  }

  public function getCode() {
    return "ypool";
  }

  public function getURL() {
    return "http://mining.ypool.net/";
  }

  public function getFields() {
    return array(
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^.{20}$#"
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    // there is no API call to list supported currencies
    return array('ltc', 'xpm', 'pts', 'dog');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array();
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $result = array();

    foreach ($this->fetchSupportedCurrencies($factory, $logger) as $cur) {
      $abbr = strtoupper($cur);
      $instance = $factory->loadCurrency($cur);
      if ($instance != null) {
        $abbr = $instance->getAbbr();
      }

      $url = "http://mining.ypool.net/api/personal_stats?coinType=" . urlencode($abbr) . "&key=" . urlencode($account['api_key']);
      $json = $this->fetchJSON($url, $logger);

      if ($json['status_code'] < 0) {
        switch ($json['status_code']) {
          case -1: throw new AccountFetchException("Invalid key parameter length");
          case -2: throw new AccountFetchException("Missing key parameter");
          case -3: throw new AccountFetchException("Invalid key parameter");
          case -5: throw new AccountFetchException("Invalid coin type for '$abbr'");
          default: throw new AccountFetchException("API returned status code " . $json['status_code']);
        }
      }

      $result[$cur] = array(
        'confirmed' => $json['balance'],
        'unconfirmed' => $json['unconfirmedBalance'],
      );
    }

    return $result;

  }

}
