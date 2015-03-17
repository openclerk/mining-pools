<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the scryptpools.com mining pool.
 */
class ScryptPools extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "scryptpools.com";
  }

  public function getCode() {
    return "scryptpools";
  }

  public function getURL() {
    return "http://doge.scryptpools.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "http://doge.scryptpools.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-17";
  }

}
