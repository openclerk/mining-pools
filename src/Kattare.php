<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the ltc.kattare.com mining pool.
 */
class Kattare extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "ltc.kattare.com";
  }

  public function getCode() {
    return "kattare";
  }

  public function getURL() {
    return "http://ltc.kattare.com";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "http://ltc.kattare.com/api.php?api_key=";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
