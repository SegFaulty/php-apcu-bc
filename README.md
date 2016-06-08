# php-apcu-bc

pure php APC-APCu backward (and forward) compatibility layer

if you get 'Error: Call to undefined function apc_store()' or you have trouble with installing pecl apcu_bu try this simple pure php replacement

simple:
```php
include 'ApcApcuCompat.php';
```


APCu | APC
---- | ----
apcu_​add         |   apc_​add
 |  ~~apc_​bin_​dump~~
 |  ~~apc_​bin_​dumpfile~~
 |  ~~apc_​bin_​load~~
 |  ~~apc_​bin_​loadfile~~
apcu_​cache_​info |    apc_​cache_​info
apcu_​cas         |   apc_​cas
apcu_​clear_​cache|    apc_​clear_​cache
 | ~~apc_​compile_​file~~
apcu_​dec         |   apc_​dec
 | ~~apc_​define_​constants~~
apcu_​delete      |   apc_​delete
 | ~~apc_​delete_​file~~
~~apcu_​entry~~ |
apcu_​exists      |   apc_​exists|
apcu_​fetch       |   apc_​fetch
apcu_​inc         |   apc_​inc
 | ~~apc_​load_​constants~~
apcu_​sma_​info   |    apc_​sma_​info
apcu_​store       |   apc_​store


