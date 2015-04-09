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
 * Tests the {@link WeMineFTC} account type.
 */
class WeMineFTCTest extends AbstractDisabledMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\WeMineFTC());
  }

}
