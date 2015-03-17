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
 * Represents the OzCoin BTC mining pool.
 */
class OzCoinBTC extends AbstractMiner {

  public function getName() {
    return "OzCoin BTC";
  }

  public function getCode() {
    return "ozcoin_btc";
  }

  public function getURL() {
    return "http://ozco.in/";
  }

  public function getFields() {
    return array(
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[0-9]+_[a-zA-Z]+$#"
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

    $url = "http://ozco.in/api.php?api_key=" . $account['api_key'];
    $json = $this->fetchJSON($url, $logger);

    if (isset($json['error'])) {
      throw new AccountFetchException($json['error']);
    }

    return array(
      'btc' => array(
        'confirmed' => $json['user']['pending_payout'],
        'estimated' => $json['user']['estimated_payout'],
        'hashrate' => $json['user']['hashrate_raw']  * 1e6 /* MH/s -> H/s */,
        'workers' => count($json['worker']),
      ),
    );

  }

}
