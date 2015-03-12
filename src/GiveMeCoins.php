<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Represents the Give Me Coins mining pool.
 */
class GiveMeCoins extends AbstractMPOSAccount {

  public function getName() {
    return "Give Me Coins";
  }

  public function getCode() {
    return "givemecoins";
  }

  public function getURL() {
    return "https://give-me-coins.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    // there's no API to list supported currencies
    return array('btc', 'ltc', 'ftc', 'vtc', 'ppc', 'dog', 'sys', 'ptc');
  }

  public function getBaseAPI() {
    throw new \Exception("Should not call getBaseAPI()");
  }

  public function getBaseAPIForCurrency($cur, CurrencyFactory $factory) {
    $abbr = $cur;
    $instance = $factory->loadCurrency($cur);
    if ($instance != null) {
      $abbr = strtolower($instance->getAbbr());
    }
    return "https://give-me-coins.com/pool/api-" . $abbr . "?api_key=";
  }

}
