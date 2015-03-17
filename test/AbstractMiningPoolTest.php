<?php

namespace Account\MiningPool\Tests;

use Monolog\Logger;
use Account\AccountType;
use Account\AccountFetchException;
use Account\Tests\AbstractActiveAccountTest;
use Openclerk\Config;
use Openclerk\Currencies\Currency;

/**
 * Abstracts away common test functionality.
 */
abstract class AbstractMiningPoolTest extends AbstractActiveAccountTest {

  public function __construct(AccountType $type) {
    parent::__construct($type);
    Config::merge(array(
      // reduce throttle time for tests
      "accounts_throttle" => 1,
      "accounts_btcguild_throttle" => 15,
      "accounts_wemineltc_throttle" => 60,
    ));
  }

  /**
   * We assert that there are no hashrate currencies in {@link #fetchBalances()} that are
   * not listed in {@link #fetchSupportedHashrateCurrencies()}.
   */
  function testValidAccountMatchHashrates() {
    $supported = $this->account->fetchSupportedHashrateCurrencies($this->factory, $this->logger);
    $balances = $this->account->fetchBalances($this->getValidAccount(), $this->factory, $this->logger);

    foreach ($balances as $cur => $balance) {
      if (isset($balance['hashrate'])) {
        if (!in_array($cur, $supported)) {
          // for example, fetchBalances() returns 'ghs' but this isn't
          // returned as a currency by fetchSupportedHashrateCurrencies()
          $this->fail("Did not expect hashrate for '$cur' to be returned as a supported hashrate currency from fetchBalances()");
        }
      }
    }
  }

  /**
   * In openclerk/mining-pools, extend this to return instances of openclerk/cryptocurrencies
   */
  function loadCurrency($cur) {
    switch ($cur) {
      case "dog":
        return new \Cryptocurrency\Dogecoin();

      default:
        return null;
    }
  }

}
