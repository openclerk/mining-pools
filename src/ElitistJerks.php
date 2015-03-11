<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\DisabledAccount;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the Elitist Jerks mining pool.
 */
class ElitistJerks extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Elitist Jerks";
  }

  public function getCode() {
    return "elitistjerks";
  }

  public function getURL() {
    return "https://www.ejpool.info/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "https://www.ejpool.info/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-11";
  }

}
