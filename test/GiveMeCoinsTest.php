<?php

namespace Account\MiningPool\Tests;

use Monolog\Logger;
use Account\AccountType;
use Account\AccountFetchException;
use Account\Tests\AbstractAccountTest;
use Account\Tests\AbstractActiveAccountTest;
use Openclerk\Config;
use Openclerk\Currencies\Currency;

/**
 * Tests the {@link GiveMeCoins} account type.
 */
class GiveMeCoinsTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\GiveMeCoins());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_key' => 'edcb6df9aad8f548b552e5b518d7cb17187906966d877310955d7da67575ba86',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_key' => 'edcb6df9aad8f548b552e5b518d7cb17187906966d877310955d7da67575ba80',
    );
  }

  /**
   * Get some invalid field values.
   * @return array of fields
   */
  function getInvalidAccount() {
    return array(
      'api_key' => 'hello',
    );
  }

  function doTestValidValues($balances) {
    $this->assertEquals(0, $balances['btc']['confirmed']);
    $this->assertEquals(0, $balances['btc']['hashrate']);
    $this->assertEquals(0, $balances['ltc']['confirmed']);
    $this->assertEquals(0, $balances['ltc']['hashrate']);
    $this->assertEquals(0, $balances['ftc']['confirmed']);
    $this->assertEquals(0, $balances['ftc']['hashrate']);
    $this->assertEquals(0, $balances['dog']['confirmed']);
    $this->assertEquals(0, $balances['dog']['hashrate']);
  }

}
