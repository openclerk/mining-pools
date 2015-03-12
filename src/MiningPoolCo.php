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
 * Represents the MiningPool.co mining pool.
 */
class MiningPoolCo extends AbstractMiner implements DisabledAccount {

  public function getName() {
    return "MiningPool.co";
  }

  public function getCode() {
    return "miningpoolco";
  }

  public function getURL() {
    return "https://www.miningpool.co/";
  }

  public function getFields() {
    return array(
      // looks like a 40 character hex string
      'api_token' => array(
        'title' => "API key",
        'regexp' => "#^[a-f0-9]{40}$#",
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog', 'ltc', 'mec');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog', 'ltc', 'mec');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {
    throw new AccountFetchException("Cannot fetch balances of disabled account");
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
