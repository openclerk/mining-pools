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
 * Tests the {@link DedicatedPoolDOGE} account type.
 */
class DedicatedPoolDOGETest extends AbstractDisabledMiningPoolTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\DedicatedPoolDOGE());
  }

}
