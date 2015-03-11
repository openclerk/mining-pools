<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\DisabledAccount;

/**
 * Represents the Dogechain Pool mining pool.
 */
class DogechainPool extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Dogechain Pool";
  }

  public function getCode() {
    return "dedicatedpool_doge";
  }

  public function getURL() {
    return "http://pool.dogechain.info/";
  }

  public function fetchSupportedCurrencies(Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return null;
  }

  public function disabledAt() {
    return "2014-11-10";
  }

}
