<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the WeMineLTC mining pool.
 */
class WeMineLTC extends AbstractMMCFEAccount {

  public function getName() {
    return "WeMineLTC";
  }

  public function getCode() {
    return "wemineltc";
  }

  public function getURL() {
    return "https://www.wemineltc.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "https://www.wemineltc.com/api?api_key=";
  }

}
