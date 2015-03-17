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
 * Represents the OzCoin LTC mining pool.
 */
class OzCoinLTC extends AbstractMiner {

  public function getName() {
    return "OzCoin LTC";
  }

  public function getCode() {
    return "ozcoin_ltc";
  }

  public function getURL() {
    return "https://lc.ozcoin.net/";
  }

  public function getFields() {
    return array(
      'api_key' => array(
        'title' => "API key",
        'regexp' => "#^[0-9]+_[a-zA-Z]+$#"
      ),
    );
  }

  public function fetchSupportedCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchSupportedHashrateCurrencies(CurrencyFactory $factory, Logger $logger) {
    return array('ltc');
  }

  public function fetchBalances($account, CurrencyFactory $factory, Logger $logger) {

    $url = "https://lc.ozcoin.net/api.php?api_key=" . $account['api_key'];
    $json = $this->fetchJSON($url, $logger);

    if (isset($json['error'])) {
      throw new AccountFetchException($json['error']);
    }

    return array(
      'ltc' => array(
        'confirmed' => $json['user']['pending_payout'],
        'estimated' => $json['user']['estimated_payout'],
        'hashrate' => $json['user']['hashrate_raw']  * 1e3 /* KH/s -> H/s */,
        'workers' => count($json['worker']),
      ),
    );

  }

  /**
   * OzCoin LTC returns HTML in the JSON response, so we strip out this HTML
   * @throws FetchException if the JSON could not be read
   */
  function jsonDecode($raw) {
    $raw = preg_replace("/<br[^<]*>.+<br[^<]*>/ims", "", $raw);
    return Fetch::jsonDecode($raw);
  }

}
