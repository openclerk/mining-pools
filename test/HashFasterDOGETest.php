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
 * Tests the {@link HashFasterDOGE} account type.
 */
class HashFasterDOGETest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\HashFasterDOGE());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_key' => 'ec39fac66bebd8c5ae58ab19c58a8d2b4f2480108134fdab15e9ae59737ab98a',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_key' => 'ec39fac66bebd8c5ae58ab19c58a8d2b4f2480108134fdab15e9ae59737ab981',
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
    $this->assertEquals(0, $balances['dog']['confirmed']);
    $this->assertEquals(0, $balances['dog']['hashrate']);
  }

}
