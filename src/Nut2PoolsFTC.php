<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Nut2Pools FTC mining pool.
 */
class Nut2PoolsFTC extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Nut2Pools FTC";
  }

  public function getCode() {
    return "nut2pools_ftc";
  }

  public function getURL() {
    return "https://ftc.nut2pools.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ftc');
  }

  public function getBaseAPI() {
    return "https://ftc.nut2pools.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
