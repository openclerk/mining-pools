<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Account\Account;
use \Account\Miner;
use \Account\DisabledAccount;
use \Account\SimpleAccountType;
use \Account\AccountFetchException;
use \Apis\FetchException;
use \Apis\FetchHttpException;
use \Apis\Fetch;
use \Openclerk\Currencies\CurrencyFactory;

/**
 * Basic miner type.
 */
abstract class AbstractMiner extends SimpleAccountType implements Miner {

  /**
   * Fetch the JSON from the given GET URL, or throw a
   * {@Link AccountFetchException} if something bad happened.
   */
  function fetchJSON($url, Logger $logger) {
    $logger->info($url);

    try {
      $this->throttle($logger);
      $raw = Fetch::get($url);
    } catch (FetchHttpException $e) {
      throw new AccountFetchException($e->getContent(), $e);
    }

    try {
      $json = Fetch::jsonDecode($raw);
    } catch (FetchException $e) {
      $message = strlen($raw) < 64 ? $e->getMessage() : $raw;
      throw new AccountFetchException($message, $e);
    }

    return $json;
  }

}
