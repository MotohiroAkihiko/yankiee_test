<?php
/**
 * 拡張Database_Queryクラス
 *
 */
class Database_Query extends \Fuel\Core\Database_Query
{
	public $seq_name = null; // custom:シーケンス名
	
	/**
	 * Execute the current query on the given database.
	 *
	 * @param   mixed   $db Database instance or name of instance
	 *
	 * @return  object   Database_Result for SELECT queries
	 * @return  mixed    the insert id for INSERT queries
	 * @return  integer  number of affected rows for all other queries
	 */
	public function execute($db = null)
	{
		if ( ! is_object($db))
		{
			// Get the database instance. If this query is a instance of
			// Database_Query_Builder_Select then use the slave connection if configured
			$db = \Database_Connection::instance($db, null, ! $this instanceof \Database_Query_Builder_Select);
		}

		// Compile the SQL query
		$sql = $this->compile($db);

		switch(strtoupper(substr(ltrim($sql,'('), 0, 6)))
		{
			case 'SELECT':
				$this->_type = \DB::SELECT;
				break;
			case 'INSERT':
			case 'CREATE':
				$this->_type = \DB::INSERT;
				break;
		}

		if ($db->caching() and ! empty($this->_lifetime) and $this->_type === DB::SELECT)
		{
			$cache_key = empty($this->_cache_key) ?
				'db.'.md5('Database_Connection::query("'.$db.'", "'.$sql.'")') : $this->_cache_key;
			$cache = \Cache::forge($cache_key);
			try
			{
				$result = $cache->get();
				return new Database_Result_Cached($result, $sql, $this->_as_object);
			}
			catch (CacheNotFoundException $e) {}
		}

		// Execute the query
		\DB::$query_count++;
		$result = $db->query($this->_type, $sql, $this->_as_object, $this->seq_name); // custom:シーケンス名を渡す

		// Cache the result if needed
		if (isset($cache) and ($this->_cache_all or $result->count()))
		{
			$cache->set_expiration($this->_lifetime)->set_contents($result->as_array())->set();
		}

		return $result;
	}

}
