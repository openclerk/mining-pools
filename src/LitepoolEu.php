<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the litepool.eu mining pool.
 */
class LitepoolEu extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "litepool.eu";
  }

  public function getCode() {
    return "litepooleu";
  }

  public function getURL() {
    return "http://litepool.eu/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function getBaseAPI() {
    return "http://litepool.eu/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-12";
  }

}
