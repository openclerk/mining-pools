<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the HashFaster DOGE mining pool.
 */
class HashFasterDOGE extends AbstractMPOSAccount {

  public function getName() {
    return "HashFaster DOGE";
  }

  public function getCode() {
    return "hashfaster_doge";
  }

  public function getURL() {
    return "https://doge.hashfaster.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "https://doge.hashfaster.com/index.php?page=api&";
  }

}
