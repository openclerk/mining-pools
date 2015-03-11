<?php

namespace Account\MiningPool;

use \Monolog\Logger;

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

  public function fetchSupportedCurrencies(Logger $logger) {
    return array('dgc');
  }

  public function getBaseAPI() {
    return "http://dgc.cryptopools.com/index.php?page=api&";
  }

}
