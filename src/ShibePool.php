<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Shibe Pool mining pool.
 */
class ShibePool extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Shibe Pool";
  }

  public function getCode() {
    return "shibepool";
  }

  public function getURL() {
    return "http://shibepool.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "http://shibepool.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2014-10-09";
  }

}
