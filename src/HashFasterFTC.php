<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the HashFaster FTC mining pool.
 */
class HashFasterFTC extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "HashFaster FTC";
  }

  public function getCode() {
    return "hashfaster_ftc";
  }

  public function getURL() {
    return "https://ftc.hashfaster.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ftc');
  }

  public function getBaseAPI() {
    return "http://ftc.hashfaster.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
