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
 * Tests the {@link KhoreNVC} account type.
 */
class KhoreNVCTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\KhoreNVC());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_key' => '4aadf31bd1bbf7837f13c1560c14b4103f787111abc31b454d524de7b33c5d4f',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_key' => '4aadf31bd1bbf7837f13c1560c14b4103f787111abc31b454d524de7b33c5d40',
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
    $this->assertEquals(0, $balances['nvc']['confirmed']);
    $this->assertEquals(0, $balances['nvc']['hashrate']);
  }

}
