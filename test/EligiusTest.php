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
 * Tests the {@link Eligius} account type.
 */
class EligiusTest extends AbstractMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\Eligius());
  }

  /**
   * Get some field values for a valid account.
   * @return array of fields
   */
  function getValidAccount() {
    return array(
      'btc_address' => '1CS7gyvYjMyzAPwLtaVoRTXsdAxhfMSsUy',
    );
  }

  /**
   * Get some field values for a missing account,
   * but one that is still valid according to the fields.
   * @return array of fields
   */
  function getMissingAccount() {
    return array(
      'btc_address' => '17eTMdqaFRSttfBYB9chKEzHubECZPTS6p',
    );
  }

  /**
   * Get some invalid field values.
   * @return array of fields
   */
  function getInvalidAccount() {
    return array(
      'btc_address' => 'hello',
    );
  }

  function doTestValidValues($balances) {
    $this->assertGreaterThanOrEqual(0, $balances['btc']['confirmed']);
    $this->assertGreaterThanOrEqual(0, $balances['btc']['hashrate']);
  }

}
