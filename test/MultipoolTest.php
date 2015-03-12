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
 * Tests the {@link Multipool} account type.
 */
class MultipoolTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\Multipool());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_key' => '674219722ba686793d427dbe16fc0e884bdf2cf9f43ebdd2fd22a84e2fd36c01',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_key' => '674219722ba686793d427dbe16fc0e884bdf2cf9f43ebdd2fd22a84e2fd36c00',
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
    $this->assertEquals(0, $balances['ltc']['confirmed']);
    $this->assertEquals(0, $balances['ltc']['hashrate']);
    $this->assertEquals(0, $balances['dog']['confirmed']);
    $this->assertEquals(0, $balances['dog']['hashrate']);
  }

}
