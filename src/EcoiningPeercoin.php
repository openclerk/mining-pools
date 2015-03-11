<?php

namespace Account\MiningPool;

use \Monolog\Logger;

/**
 * Represents the Ecoining Peercoin mining pool.
 */
class EcoiningPeercoin extends AbstractMPOSAccount {

  public function getName() {
    return "Econining Peercoin";
  }

  public function getCode() {
    return "ecoining_ppc";
  }

  public function getURL() {
    return "https://peercoin.ecoining.com/";
  }

  public function fetchSupportedCurrencies(Logger $logger) {
    return array('ppc');
  }

  public function getBaseAPI() {
    return "https://peercoin.ecoining.com/index.php?page=api&";
  }

}
