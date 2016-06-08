<?php
/**
 * simple APC <=> APCu compatibility layer
 * if apc_* (the old apc-extension) not exist, it will be rebuild with apcu_* functions
 * if apcu_* function (the new php7 apc extension) not exists it will be rebuild with apc_* functions
 * no need to install pecl apcu_bc module (with it's install problems)
 * simple:
 *
 * include apcApcuCompat.php;
 *
 * fertisch!
 */
if( !is_callable('apc_store') AND is_callable('apcu_store') ){

	/**
	 * Retrieves cached information and meta-data from APC's data store
	 * @link http://php.net/manual/en/function.apc-cache-info.php
	 * @param string $cache_type If cache_type is "user", information about the user cache will be returned.
	 * If cache_type is "filehits", information about which files have been served from the bytecode
	 * cache for the current request will be returned. This feature must be enabled at compile time
	 * using --enable-filehits. If an invalid or no cache_type is specified, information about the
	 * system cache (cached files) will be returned.
	 * @param bool $limited If limited is TRUE, the return value will exclude the individual list
	 * of cache entries. This is useful when trying to optimize calls for statistics gathering.
	 * @return array|bool Array of cached data (and meta-data) or FALSE on failure.
	 */
	function apc_cache_info($cache_type = '', $limited = false){
		if( $cache_type!='user' ){
			throw new RuntimeException('only type user is supported in apcu');
		}
		return apcu_cache_info($limited);
	}

	/**
	 * Clears the APC cache
	 * @link http://php.net/manual/en/function.apc-clear-cache.php
	 * @param string $cache_type If cache_type is "user", the user cache will be cleared;
	 * otherwise, the system cache (cached files) will be cleared.
	 * @return bool Returns TRUE on success or FALSE on failure.
	 */
	function apc_clear_cache($cache_type = ''){
		if( $cache_type!='user' ){
			throw new RuntimeException('only type user is supported in apcu');
		}
		return apcu_clear_cache();
	}

	/**
	 * Retrieves APC's Shared Memory Allocation information
	 * @link http://php.net/manual/en/function.apc-sma-info.php
	 * @param bool $limited When set to FALSE (default) apc_sma_info() will
	 * return a detailed information about each segment.
	 * @return array|bool Array of Shared Memory Allocation data; FALSE on failure.
	 */
	function apc_sma_info($limited = false){
		return apcu_sma_info($limited);
	}

	/**
	 * Cache a variable in the data store
	 * @link http://php.net/manual/en/function.apc-store.php
	 * @param string|array $key String: Store the variable using this name. Keys are cache-unique,
	 * so storing a second value with the same key will overwrite the original value.
	 * Array: Names in key, variables in value.
	 * @param mixed $var [optional] The variable to store
	 * @param int $ttl [optional]  Time To Live; store var in the cache for ttl seconds. After the ttl has passed,
	 * the stored variable will be expunged from the cache (on the next request). If no ttl is supplied
	 * (or if the ttl is 0), the value will persist until it is removed from the cache manually,
	 * or otherwise fails to exist in the cache (clear, restart, etc.).
	 * @return bool|array Returns TRUE on success or FALSE on failure | array with error keys.
	 */
	function apc_store($key, $var, $ttl = 0){
		return apcu_store($key, $var, $ttl);
	}

	/**
	 * Fetch a stored variable from the cache
	 * @link http://php.net/manual/en/function.apc-fetch.php
	 * @param string|string[] $key The key used to store the value (with apc_store()).
	 * If an array is passed then each element is fetched and returned.
	 * @param bool $success Set to TRUE in success and FALSE in failure.
	 * @return mixed The stored variable or array of variables on success; FALSE on failure.
	 */
	function apc_fetch($key, &$success = null){
		return apcu_fetch($key, $success);
	}

	/**
	 * Removes a stored variable from the cache
	 * @link http://php.net/manual/en/function.apc-delete.php
	 * @param string|string[]|APCIterator $key The key used to store the value (with apc_store()).
	 * @return bool|string[] Returns TRUE on success or FALSE on failure. For array of keys returns list of failed keys.
	 */
	function apc_delete($key){
		apcu_delete($key);
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_define_constants(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * Caches a variable in the data store, only if it's not already stored
	 * @link http://php.net/manual/en/function.apc-add.php
	 * @param string $key Store the variable using this name. Keys are cache-unique,
	 * so attempting to use apc_add() to store data with a key that already exists will not
	 * overwrite the existing data, and will instead return FALSE. (This is the only difference
	 * between apc_add() and apc_store().)
	 * @param mixed $var The variable to store
	 * @param int $ttl Time To Live; store var in the cache for ttl seconds. After the ttl has passed,
	 * the stored variable will be expunged from the cache (on the next request). If no ttl is supplied
	 * (or if the ttl is 0), the value will persist until it is removed from the cache manually,
	 * or otherwise fails to exist in the cache (clear, restart, etc.).
	 * @return bool
	 */
	function apc_add($key, $var, $ttl = 0){
		return apcu_add($key, $var, $ttl);
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_compile_file(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_load_constants(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * Checks if APC key exists
	 * @link http://php.net/manual/en/function.apc-exists.php
	 * @param bool|string[] $keys A string, or an array of strings, that contain keys.
	 * @return bool|string[] Returns TRUE if the key exists, otherwise FALSE
	 * Or if an array was passed to keys, then an array is returned that
	 * contains all existing keys, or an empty array if none exist.
	 */
	function apc_exists($keys){
		return apcu_exists($keys);
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_delete_file(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * Increase a stored number
	 * @link http://php.net/manual/en/function.apc-inc.php
	 * @param string $key The key of the value being increased.
	 * @param int $step The step, or value to increase.
	 * @param bool $success Optionally pass the success or fail boolean value to this referenced variable.
	 * @return int|bool Returns the current value of key's value on success, or FALSE on failure.
	 */
	function apc_inc($key, $step = 1, &$success = null){
		return apcu_inc($key, $step, $success);
	}

	/**
	 * Decrease a stored number
	 * @link http://php.net/manual/en/function.apc-dec.php
	 * @param string $key The key of the value being decreased.
	 * @param int $step The step, or value to decrease.
	 * @param bool $success Optionally pass the success or fail boolean value to this referenced variable.
	 * @return int|bool Returns the current value of key's value on success, or FALSE on failure.
	 */
	function apc_dec($key, $step = 1, &$success = null){
		return apcu_dec($key, $step, $success);
	}

	/**
	 * @link http://php.net/manual/en/function.apc-cas.php
	 * @param string $key
	 * @param int $old
	 * @param int $new
	 * @return bool
	 */
	function apc_cas($key, $old, $new){
		return apcu_cas($key, $old, $new);
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_bin_dump(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_bin_dumpfile(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_bin_load(){
		throw new RuntimeException('not inmplemented in apcu');
	}

	/**
	 * @deprecated not implemented in apcu
	 */
	function apc_bin_loadfile(){
		throw new RuntimeException('not inmplemented in apcu');
	}


}elseif( is_callable('apc_store') AND !is_callable('apcu_store') ){

	/**
	 * Retrieves cached information and meta-data from APC's data store
	 * @link http://php.net/manual/en/function.apcu-cache-info.php
	 * @param bool $limited If limited is TRUE, the return value will exclude the individual list
	 * of cache entries. This is useful when trying to optimize calls for statistics gathering.
	 * @return array|bool Array of cached data (and meta-data) or FALSE on failure.
	 */
	function apcu_cache_info($limited = false){
		return apc_cache_info('user', $limited);
	}

	/**
	 * Clears the APC cache
	 * @link http://php.net/manual/en/function.apcu-clear-cache.php
	 * @return bool Returns TRUE on success or FALSE on failure.
	 */
	function apcu_clear_cache(){
		return apc_clear_cache('user');
	}

	/**
	 * Retrieves APC's Shared Memory Allocation information
	 * @link http://php.net/manual/en/function.apcu-sma-info.php
	 * @param bool $limited When set to FALSE (default) apc_sma_info() will
	 * return a detailed information about each segment.
	 * @return array|bool Array of Shared Memory Allocation data; FALSE on failure.
	 */
	function apcu_sma_info($limited = false){
		return apc_sma_info($limited);
	}

	/**
	 * Cache a variable in the data store
	 * @link http://php.net/manual/en/function.apcu-store.php
	 * @param string|array $key String: Store the variable using this name. Keys are cache-unique,
	 * so storing a second value with the same key will overwrite the original value.
	 * Array: Names in key, variables in value.
	 * @param mixed $var [optional] The variable to store
	 * @param int $ttl [optional]  Time To Live; store var in the cache for ttl seconds. After the ttl has passed,
	 * the stored variable will be expunged from the cache (on the next request). If no ttl is supplied
	 * (or if the ttl is 0), the value will persist until it is removed from the cache manually,
	 * or otherwise fails to exist in the cache (clear, restart, etc.).
	 * @return bool|array Returns TRUE on success or FALSE on failure | array with error keys.
	 */
	function apcu_store($key, $var, $ttl = 0){
		return apc_store($key, $var, $ttl);
	}

	/**
	 * Fetch a stored variable from the cache
	 * @link http://php.net/manual/en/function.apcu-fetch.php
	 * @param string|string[] $key The key used to store the value (with apcu_store()).
	 * If an array is passed then each element is fetched and returned.
	 * @param bool $success Set to TRUE in success and FALSE in failure.
	 * @return mixed The stored variable or array of variables on success; FALSE on failure.
	 */
	function apcu_fetch($key, &$success = null){
		return apc_fetch($key, $success);
	}

	/**
	 * Removes a stored variable from the cache
	 * @link http://php.net/manual/en/function.apcu-delete.php
	 * @param string|string[]|APCIterator $key The key used to store the value (with apcu_store()).
	 * @return bool|string[] Returns TRUE on success or FALSE on failure. For array of keys returns list of failed keys.
	 */
	function apcu_delete($key){
		apc_delete($key);
	}

	/**
	 * Caches a variable in the data store, only if it's not already stored
	 * @link http://php.net/manual/en/function.apcu-add.php
	 * @param string $key Store the variable using this name. Keys are cache-unique,
	 * so attempting to use apc_add() to store data with a key that already exists will not
	 * overwrite the existing data, and will instead return FALSE. (This is the only difference
	 * between apcu_add() and apcu_store().)
	 * @param mixed $var The variable to store
	 * @param int $ttl Time To Live; store var in the cache for ttl seconds. After the ttl has passed,
	 * the stored variable will be expunged from the cache (on the next request). If no ttl is supplied
	 * (or if the ttl is 0), the value will persist until it is removed from the cache manually,
	 * or otherwise fails to exist in the cache (clear, restart, etc.).
	 * @return bool
	 */
	function apcu_add($key, $var, $ttl = 0){
		return apc_add($key, $var, $ttl);
	}

	/**
	 * Checks if APC key exists
	 * @link http://php.net/manual/en/function.apcu-exists.php
	 * @param bool|string[] $keys A string, or an array of strings, that contain keys.
	 * @return bool|string[] Returns TRUE if the key exists, otherwise FALSE
	 * Or if an array was passed to keys, then an array is returned that
	 * contains all existing keys, or an empty array if none exist.
	 */
	function apcu_exists($keys){
		return apc_exists($keys);
	}

	/**
	 * Increase a stored number
	 * @link http://php.net/manual/en/function.apcu-inc.php
	 * @param string $key The key of the value being increased.
	 * @param int $step The step, or value to increase.
	 * @param bool $success Optionally pass the success or fail boolean value to this referenced variable.
	 * @return int|bool Returns the current value of key's value on success, or FALSE on failure.
	 */
	function apcu_inc($key, $step = 1, &$success = null){
		return apc_inc($key, $step, $success);
	}

	/**
	 * Decrease a stored number
	 * @link http://php.net/manual/en/function.apcu-dec.php
	 * @param string $key The key of the value being decreased.
	 * @param int $step The step, or value to decrease.
	 * @param bool $success Optionally pass the success or fail boolean value to this referenced variable.
	 * @return int|bool Returns the current value of key's value on success, or FALSE on failure.
	 */
	function apcu_dec($key, $step = 1, &$success = null){
		return apc_dec($key, $step, $success);
	}

	/**
	 * @link http://php.net/manual/en/function.apcu-cas.php
	 * @param string $key
	 * @param int $old
	 * @param int $new
	 * @return bool
	 */
	function apcu_cas($key, $old, $new){
		return apc_cas($key, $old, $new);
	}
}
