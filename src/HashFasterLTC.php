<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the HashFaster LTC mining pool.
 */
class HashFasterLTC extends AbstractMPOSAccount {

  public function getName() {
    return "HashFaster LTC";
  }

  public function getCode() {
    return "hashfaster_ltc";
  }

  public function getURL() {
    return "https://ltc.hashfaster.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "https://ltc.hashfaster.com/index.php?page=api&";
  }

}
