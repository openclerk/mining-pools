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
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the 50BTC mining pool.
 */
class FiftyBTC extends AbstractMiner implements DisabledAccount {

  public function getName() {
    return "50BTC";
  }

  public function getCode() {
    return "50btc";
  }

  public function getURL() {
    return "https://50btc.com/";
  }

  public function getFields() {
    return array(
      // looks like a number followed by a 32 character hex string
      'api_token' => array(
        'title' => "API key",
        'regexp' => "#^[0-9]+\-[a-f0-9]+$#",
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array();
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array();
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {
    throw new AccountFetchException("Cannot fetch balances of disabled account");
  }

  public function disabledAt() {
    return "2015-03-11";
  }

}
