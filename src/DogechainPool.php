<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\DisabledAccount;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the Dogechain Pool mining pool.
 */
class DogechainPool extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Dogechain Pool";
  }

  public function getCode() {
    return "dogechainpool";
  }

  public function getURL() {
    return "http://pool.dogechain.info/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "https://pool.dogechain.info/index.php?page=api&";
  }

  public function disabledAt() {
    return "2014-11-10";
  }

}
