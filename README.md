openclerk/mining-pools
======================

A library for accessing live balances and hashrate data for accounts on many different mining pools,
used by [Openclerk](http://openclerk.org) and live on [CryptFolio](https://cryptfolio.com).

This extends on the abstract currency definitions provided by
[openclerk/currencies](https://github.com/openclerk/currencies)
and the abstract account definitions provided by
[openclerk/accounts](https://github.com/openclerk/accounts).

## Installing

Include `openclerk/mining-pools` as a requirement in your project `composer.json`,
and run `composer update` to install it into your project:

```json
{
  "require": {
    "openclerk/mining-pools": "dev-master"
  }
}
```

* [Mining pools supported](https://github.com/openclerk/mining-pools/tree/master/src)

## Using

First, define a way to load Currency instances from three-character codes, according to [openclerk/currencies](https://github.com/openclerk/currencies):

```php
use \DiscoveredComponents\Currencies;
use \Openclerk\Currencies\Currency;
use \Openclerk\Currencies\CurrencyFactory;

class DiscoveredCurrencyFactory implements CurrencyFactory {

  /**
   * @return a {@link Currency} for the given currency code, or {@code null}
   *   if none could be found
   */
  public function loadCurrency($cur) {
    if (Currencies::hasKey($cur)) {
      return Currencies::getInstance($cur);
    }
    return null;
  }

}
```

Get the currencies supported by a mining pool:

```php
use \Monolog\Logger;

$logger = new Logger("log");
$factory = new DiscoveredCurrencyFactory();

$instance = new Account\MiningPool\Slush();
print_r($instance->fetchSupportedCurrencies($factory, $logger));
// returns ['btc', 'nmc']
```

Get the current balances (confirmed, unconfirmed, estimated) and hashrates for a mining pool account:

```php
use \Monolog\Logger;

$logger = new Logger("log");
$factory = new DiscoveredCurrencyFactory();

$instance = new Account\MiningPool\Slush();

$account = array(
  'api_token' => '270245-e26365e4ca8f97ddde8c76a23ec18758',
);

$balances = $instance->fetchBalances($account, $factory, $logger);
echo $balances['btc']['confirmed'];     // in BTC
echo $balances['btc']['unconfirmed'];
echo $balances['btc']['estimated'];
echo $balances['btc']['hashrate'];      // in MH/s
echo $balances['nmc']['confirmed'];     // in NMC
echo $balances['nmc']['unconfirmed'];
echo $balances['nmc']['estimated'];
echo $balances['nmc']['hashrate'];      // in MH/s
```

## Tests

Each mining pool comes with a suite of tests to check each associated service.

```
composer install
vendor/bin/phpunit
```

To run the tests for a single mining pool:

```
vendor/bin/phpunit --bootstrap "vendor/autoload.php" test/SlushTest
```

To get debug output for the tests (such as CURL requests and decoded output),
add the `--debug` switch to your `vendor/bin/phpunit` command.

## Donate

[Donations are appreciated](https://code.google.com/p/openclerk/wiki/Donating).

## Contributing

Pull requests that contribute new mining pools are welcome.

Make sure that you also provide an associated Test suite so that the mining pool is automatically testable.

## TODO

1. Generate README list of mining pools automatically
1. Link to live APIs on CryptFolio
1. CI build server and link to test results
