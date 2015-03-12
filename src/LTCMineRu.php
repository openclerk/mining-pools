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
 * Represents the LTCMine.ru mining pool.
 */
class LTCMineRu extends AbstractMiner implements DisabledAccount {

  public function getName() {
    return "LTCMine.ru";
  }

  public function getCode() {
    return "ltcmineru";
  }

  public function getURL() {
    return "http://ltcmine.ru";
  }

  public function getFields() {
    return array(
      // looks like a username, followed by a 32 character hex string
      'api_token' => array(
        'title' => "API key",
        'regexp' => "#^.+_[a-f0-9]+$#",
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {
    throw new AccountFetchException("Cannot fetch balances of disabled account");
  }

  public function disabledAt() {
    return "2014-11-07";
  }

}
