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
 * Represents the MuPool mining pool.
 */
class MuPool extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "MuPool";
  }

  public function getCode() {
    return "mupool";
  }

  public function getURL() {
    return "https://mupool.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "https://mupool.com/index.php?page=api&coin=...&";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
