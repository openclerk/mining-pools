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
 * Tests the {@link WestHash} account type.
 */
class WestHashTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\WestHash());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_id' => '10507',
      'api_key' => 'fabcd8e5-e214-4362-936c-706c6295e78c',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_id' => '10507',
      'api_key' => 'fabcd8e5-e214-4362-936c-706c6295e780',
    );
  }

  /**
   * Get some invalid field values.
   * @return array of fields
   */
  function getInvalidAccount() {
    return array(
      'api_id' => '10507',
      'api_key' => 'hello',
    );
  }

  function doTestValidValues($balances) {
    $this->assertEquals(0, $balances['btc']['confirmed']);
  }

}
