<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\DisabledAccount;

/**
 * Represents the dogepool.pw mining pool.
 */
class DogepoolPw extends AbstractMPOSAccount implements DisabledAccount {

  public function getName() {
    return "dogepool.pw";
  }

  public function getCode() {
    return "dogepoolpw";
  }

  public function getURL() {
    return "http://dogepool.pw/";
  }

  public function fetchSupportedCurrencies(Logger $logger) {
    return array('dog');
  }

  public function getBaseAPI() {
    return "http://dogepool.pw/index.php?page=api&";
  }

  public function disabledAt() {
    return "2014-11-10";
  }

}
