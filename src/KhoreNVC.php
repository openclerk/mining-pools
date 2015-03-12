<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the nvc.khore.org mining pool.
 */
class KhoreNVC extends AbstractMPOSAccount {

  public function getName() {
    return "nvc.khore.org";
  }

  public function getCode() {
    return "khore";
  }

  public function getURL() {
    return "https://nvc.khore.org/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('nvc');
  }

  public function getBaseAPI() {
    return "https://nvc.khore.org/api?";
  }

}
