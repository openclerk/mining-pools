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
 * Tests the {@link CryptoTrollDOGE} account type.
 */
class CryptoTrollDOGETest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\CryptoTrollDOGE());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'api_key' => 'be776993667ddfdab8d59f6b3619287f44ee248f65265a7ad8470e641921f4e8',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'api_key' => 'be776993667ddfdab8d59f6b3619287f44ee248f65265a7ad8470e641921f4e0',
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
