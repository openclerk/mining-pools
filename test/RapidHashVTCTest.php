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
 * Tests the {@link RapidHashVTC} account type.
 */
class RapidHashVTCTest extends AbstractAccountTest {

  function __construct() {
    parent::__construct(new \Account\MiningPool\RapidHashVTC());
  }

}
