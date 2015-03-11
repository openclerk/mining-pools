<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the D2 WDC mining pool.
 */
class D2WDC extends AbstractMPOSAccount {

  public function getName() {
    return "D2 WDC";
  }

  public function getCode() {
    return "d2_wdc";
  }

  public function getURL() {
    return "https://wdc.d2.cc/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('wdc');
  }

  public function getBaseAPI() {
    return "https://wdc.d2.cc/api.php?";
  }

}
