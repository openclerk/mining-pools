<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Pool-X.eu mining pool.
 */
class PoolX extends AbstractMMCFEAccount implements DisabledAccount {

  public function getName() {
    return "Pool-X.eu";
  }

  public function getCode() {
    return "poolx";
  }

  public function getURL() {
    return "http://pool-x.eu/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "http://pool-x.eu/api?api_key=";
  }

  public function disabledAt() {
    return "2015-03-17";
  }

}
