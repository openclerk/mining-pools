<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the WeMineFTC mining pool.
 */
class WeMineFTC extends AbstractMMCFEAccount implements DisabledAccount {

  public function getName() {
    return "WeMineFTC";
  }

  public function getCode() {
    return "wemineftc";
  }

  public function getURL() {
    return "https://www.wemineftc.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ftc');
  }

  public function getBaseAPI() {
    return "https://www.wemineftc.com/api?api_key=";
  }

  public function disabledAt() {
    return "2015-03-17";
  }

}
