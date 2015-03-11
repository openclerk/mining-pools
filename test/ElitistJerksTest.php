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
 * Tests the {@link ElitistJerks} account type.
 */
class ElitistJerksTest extends AbstractAccountTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\ElitistJerks());
  }

}
