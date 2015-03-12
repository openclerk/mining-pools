<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the lite.coin-pool.com mining pool.
 */
class Lite_CoinPool extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "lite.coin-pool.com";
  }

  public function getCode() {
    return "lite_coinpool";
  }

  public function getURL() {
    return "http://lite.coin-pool.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "http://lite.coin-pool.com/";
  }

  public function disabledAt() {
    return "2014-02-17";
  }

}
