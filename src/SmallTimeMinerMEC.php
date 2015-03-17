<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Small Time Miner MEC mining pool.
 */
class SmallTimeMinerMEC extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "Small Time Miner MEC";
  }

  public function getCode() {
    return "smalltimeminer_mec";
  }

  public function getURL() {
    return "http://meg.smalltimeminer.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('mec');
  }

  public function getBaseAPI() {
    return "http://meg.smalltimeminer.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2014-04-07";
  }

}
