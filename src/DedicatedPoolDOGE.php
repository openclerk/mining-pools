<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\DisabledAccount;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the DedicatedPool DOGE mining pool.
 */
class DedicatedPoolDOGE extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "dedicatedpool.com DOGE";
  }

  public function getCode() {
    return "dedicatedpool_doge";
  }

  public function getURL() {
    return "http://doge.dedicatedpool.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "http://doge.dedicatedpool.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-11";
  }

}
