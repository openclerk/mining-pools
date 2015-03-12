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
 * Tests the {@link Nut2PoolsFTC} account type.
 */
class Nut2PoolsFTCTest extends AbstractAccountTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\Nut2PoolsFTC());
  }

}
