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
 * Represents the TripleMining mining pool.
 */
class TripleMining extends AbstractMiner {

  public function getName() {
    return "TripleMining";
  }

  public function getCode() {
    return "triplemining";
  }

  public function getURL() {
    return "http://ozco.in/";
  }

  public function getFields() {
    return array(
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[a-f0-9]{32}+$#"
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = "http://api.triplemining.com/json/" . $account['api_key'];
    $json = $this->fetchJSON($url, $logger);

    return array(
      'btc' => array(
        'confirmed' => $json['confirmed_reward'],
        'estimated' => $json['estimated_payout'],
        'hashrate' => $json['hashrate'] * 1e6 /* MH/s -> H/s */,
        'workers' => count($json['workers']),
      ),
    );

  }

}
