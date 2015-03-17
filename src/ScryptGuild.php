<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the ScryptGuild mining pool.
 */
class ScryptGuild extends AbstractMiner implements DisabledAccount {

  public function getName() {
    return "ScryptGuild";
  }

  public function getCode() {
    return "scryptguild";
  }

  public function getURL() {
    return "http://www.scryptguild.com/";
  }

  public function getFields() {
    return array(
      // looks like a 32 character hex string
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[a-f0-9]{32}$#",
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc', 'dog', 'ltc', 'wdc', 'dgc');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc', 'dog', 'ltc', 'wdc', 'dgc');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {
    throw new AccountFetchException("Cannot fetch balances of disabled account");
  }

  public function disabledAt() {
    return "2014-11-07";
  }
}
