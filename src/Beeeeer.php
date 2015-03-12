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
 * Represents the b(e^5)r.org mining pool.
 */
class Beeeeer extends SimpleAccountType implements Miner, DisabledAccount {

  public function getName() {
    return "b(e^5)r.org";
  }

  public function getCode() {
    return "beeeeer";
  }

  public function getURL() {
    return "http://beeeeer.org/";
  }

  public function getFields() {
    return array(
      // valid XPM address
      'api_token' => array(
        'title' => "XPM Address",
        'regexp' => "#^[A][A-Za-z0-9]{26,33}$#",
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
    return "2014-11-07";
  }

}
