<?php

namespace Account\MiningPool;

use \Monolog\Logger;
use \Openclerk\Currencies\CurrencyFactory;
use \Account\DisabledAccount;

/**
 * Represents the Hash-to-Coins mining pool.
 */
class HashToCoins extends AbstractMPOSAccount {

  public function getName() {
    return "Hash-to-Coins";
  }

  public function getCode() {
    return "hashtocoins";
  }

  public function getURL() {
    return "https://hash-to-coins.com/";
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    // there is no API to return this list
    // only returning 3 digit currency codes
    return array('ari', 'aur', 'btb', 'btm', 'cap', 'csc', 'dgb', 'emd',
        'flo', 'frk', 'fst', 'gld', 'hbn', 'lot', 'ltc', 'mec',
        'myr', 'net', 'nvc', 'pot', 'qtl', 'str', 'sxc', 'ttc',
        'wdc');
  }

  public function getBaseAPI() {
    return "https://hash-to-coins.com/index.php?page=api&";
  }

  /**
   * @override we just use a single API call to get all balances
   * @return all account balances
   * @throws AccountFetchException if something bad happened
   */
  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $result = array();
    $balances = $this->fetchMPOSAPI("getuserbalances", null, $account, $factory, $logger);

    foreach ($this->fetchSupportedCurrencies($factory, $logger) as $cur) {
      $abbr = strtoupper($cur);
      $instance = $factory->loadCurrency($cur);
      if ($instance != null) {
        $abbr = $cur->getAbbr();
      }

      foreach ($balances as $data) {
        if ($data['tag'] == $abbr) {
          $result[$cur] = array(
            'confirmed' => $data['confirmed'],
            'unconfirmed' => $data['unconfirmed'],
            'orphaned' => $data['orphaned'],
          );
        }
      }
    }

    $status = $this->fetchMPOSAPI("getuserhashrate", null, $account, $factory, $logger);

    // NOTE assumes that the user is always mining LTC; this isn't true, but
    // this should make it easier to track autoswitching miners.
    // we need some sort of API to get currently mined coin
    $result['ltc']['hashrate'] = $status['data'];

    return $result;

  }

}
