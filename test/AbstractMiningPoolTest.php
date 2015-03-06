<?php

namespace Account\MiningPool\Tests;

use Monolog\Logger;
use Account\AccountType;
use Account\AccountFetchException;
use Account\Tests\AbstractAccountTest;
use Openclerk\Config;
use Openclerk\Currencies\Currency;

/**
 * Abstracts away common test functionality.
 */
abstract class AbstractMiningPoolTest extends AbstractAccountTest {

  /**
   * We assert that there are no hashrate currencies in {@link #fetchBalances()} that are
   * not listed in {@link #fetchSupportedHashrateCurrencies()}.
   */
  function testValidAccountMatchHashrates() {
    $supported = $this->account->fetchSupportedHashrateCurrencies($this->logger);
    $balances = $this->account->fetchBalances($this->getValidAccount(), $this->logger);

    foreach ($balances as $cur => $balance) {
      if (isset($balance['hashrate'])) {
        if (!in_array($cur, $supported)) {
          $this->fail("Did not expect hashrate for '$cur' to be returned as a supported hashrate currency from fetchBalances()");
        }
      }
    }
  }

}
