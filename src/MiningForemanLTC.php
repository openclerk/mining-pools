<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Mining Foreman LTC mining pool.
 */
class MiningForemanLTC extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Mining Foreman LTC";
  }

  public function getCode() {
    return "miningforeman";
  }

  public function getURL() {
    return "http://www.mining-foreman.org/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "http://www.mining-foreman.org/api?api_key=";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
