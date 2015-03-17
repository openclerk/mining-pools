<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the TeamDoge mining pool.
 */
class TeamDoge extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "TeamDoge";
  }

  public function getCode() {
    return "teamdoge";
  }

  public function getURL() {
    return "https://teamdoge.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "https://teamdoge.com/index.php?page=api&";
  }

  public function disabledAt() {
    return "2015-03-17";
  }

}
