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
 * Tests the {@link Lite_CoinPool} account type.
 */
class Lite_CoinPoolTest extends AbstractAccountTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\Lite_CoinPool());
  }

}
