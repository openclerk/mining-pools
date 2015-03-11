<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the CryptoTroll DOGE mining pool.
 */
class CryptoTrollDOGE extends AbstractMPOSAccount {

  public function getName() {
    return "CryptoTroll DOGE";
  }

  public function getCode() {
    return "cryptotroll_doge";
  }

  public function getURL() {
    return "http://doge.cryptotroll.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "http://doge.cryptotroll.com/index.php?page=api&";
  }

}
