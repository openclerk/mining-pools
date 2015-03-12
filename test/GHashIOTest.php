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
 * Tests the {@link GHashIO} account type.
 */
class GHashIOTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\GHashIO());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_username' => 'openclerk',
      'api_key' => 'xTcIrV0e6pw0gqHlGflECleC4Q',
      'api_secret' => 'vXmvmht54LWOKXxFC97McURpZ4',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_username' => 'openclerk',
      'api_key' => 'xTcIrV0e6pw0gqHlGflECleC40',
      'api_secret' => 'vXmvmht54LWOKXxFC97McURpZ0',
    );
  }

  /**
   * Get some invalid field values.
   * @return array of fields
   */
  function getInvalidAccount() {
    return array(
      'api_username' => 'openclerk',
      'api_key' => 'xTcIrV0e6pw0gqHlGflECleC4Q1bvxcbxcvxcnxcngnxfgnx',
      'api_secret' => 'xTcIrV0e6pw0gqHlGflECleC',
    );
  }

  function doTestValidValues($balances) {
    $this->assertEquals(0, $balances['btc']['hashrate']);
    $this->assertEquals(0, $balances['nmc']['hashrate']);

    $this->assertArrayNotHasKey('confirmed', $balances['btc']);
    $this->assertArrayNotHasKey('confirmed', $balances['nmc']);
  }

}
