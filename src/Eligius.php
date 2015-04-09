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
 * Represents the Eligius mining pool.
 */
class Eligius extends AbstractMiner implements Miner {

  public function getName() {
    return "Eligius";
  }

  public function getCode() {
    return "eligius";
  }

  public function getURL() {
    return "http://eligius.st/";
  }

  public function getFields() {
    return array(
      // looks like a 32 character hex string
      'btc_address' => array(
        'title' => "BTC Address",
        'regexp' => "#^[13][A-Za-z0-9]{26,33}$#",
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('btc');
  }

  /**
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = "http://eligius.st/~wizkid057/newstats/api.php?cmd=getuserstat&username=" . $account['btc_address'];
    $balance = $this->fetchJSON($url, $logger);

    if (isset($balance['error'])) {
      throw new AccountFetchException($balance['error']);
    }
    if ($balance['output']['lbal'] === "N/A") {
      $balance['output']['lbal'] = 0;
    }

    $url = "http://eligius.st/~wizkid057/newstats/api.php?cmd=gethashrate&username=" . $account['btc_address'];
    $hashrate = $this->fetchJSON($url, $logger);

    if (isset($hashrate['error'])) {
      throw new AccountFetchException($hashrate['error']);
    }

    return array(
      'btc' => array(
        'confirmed' => $balance['output']['lbal'] / 1e8,
        'hashrate' => $hashrate['output']['av256']['numeric'] /* H/s */,
      ),
    );

  }

}
