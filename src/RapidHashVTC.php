<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the RapidHash VTC mining pool.
 */
class RapidHashVTC extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "RapidHash VTC";
  }

  public function getCode() {
    return "rapidhash_vtc";
  }

  public function getURL() {
    return "https://vtc.rapidhash.net/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('vtc');
  }

  public function getBaseAPI() {
    return "https://vtc.rapidhash.net/index.php?page=api&";
  }

  public function disabledAt() {
    return "2014-07-11";
  }

}
