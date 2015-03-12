<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Mining Foreman FTC mining pool.
 */
class MiningForemanFTC extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Mining Foreman FTC";
  }

  public function getCode() {
    return "miningforeman_ftc";
  }

  public function getURL() {
    return "http://ftc.mining-foreman.org/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ftc');
  }

  public function getBaseAPI() {
    return "http://ftc.mining-foreman.org/api?api_key=";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
