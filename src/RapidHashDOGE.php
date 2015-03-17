<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the RapidHash DOGE mining pool.
 */
class RapidHashDOGE extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "RapidHash DOGE";
  }

  public function getCode() {
    return "rapidhash_doge";
  }

  public function getURL() {
    return "https://doge.rapidhash.net/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "https://doge.rapidhash.net/index.php?page=api&";
  }

  public function disabledAt() {
    return "2014-07-11";
  }

}
