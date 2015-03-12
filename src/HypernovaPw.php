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
 * Represents the hypernova.pw mining pool.
 */
class HypernovaPw extends SimpleAccountType implements Miner, DisabledAccount {

  public function getName() {
    return "hypernova.pw";
  }

  public function getCode() {
    return "hypernova";
  }

  public function getURL() {
    return "https://hypernova.pw";
  }

  public function getFields() {
    return array(
      'api_key' => array(
        'title' => "API Key",
        'regexp' => "#^[a-f0-9]{64}$#",
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('newt_listbox_set_current(listbox, num)');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {
    throw new AccountFetchException("Cannot fetch balances of disabled account");
  }

  public function disabledAt() {
    return "2014-09-10";
  }

}
