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
 * Tests the {@link Eobot} account type.
 */
class EobotTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\Eobot());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_id' => '83268',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_id' => '9999999999',
    );
  }

  /**
   * Get some invalid field values.
   * @return array of fields
   */
  function getInvalidAccount() {
    return array(
      'api_id' => 'hello',
    );
  }

  function doTestValidValues($balances) {
    $this->assertEquals(0, $balances['btc']['confirmed']);
    $this->assertEquals(0, $balances['btc']['hashrate']);
    $this->assertEquals(0, $balances['ltc']['confirmed']);
    $this->assertEquals(0, $balances['ltc']['hashrate']);
    $this->assertEquals(1, $balances['dog']['confirmed']);
    $this->assertEquals(0, $balances['dog']['hashrate']);
  }

}
