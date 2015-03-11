<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the CryptoPools DGC mining pool.
 */
class CryptoPoolsDGC extends AbstractMPOSAccount {

  public function getName() {
    return "CryptoPools DGC";
  }

  public function getCode() {
    return "cryptopools_dgc";
  }

  public function getURL() {
    return "http://dgc.cryptopools.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dgc');
  }

  public function getBaseAPI() {
    return "http://dgc.cryptopools.com/index.php?page=api&";
  }

}
