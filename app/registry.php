<?php
/*
 * Codengine
 * FilePath: /app/registy.php
*/

class Registry implements ArrayAccess
{
	// basic setup
	private static $instance = null;
	private $registry = array();

	public static function getInstance() {
		if(self::$instance === null) {
			self::$instance = new Registry();
		}

		return self::$instance;
	}

	private function __construct() {}
	private function __clone() {}

	// registry functions, set and get
	public function set($key, $value) {
		if (isset($this->registry[$key])) {
			throw new Exception("There is already an entry for key " . $key);
		}

		$this->registry[$key] = $value;
	}

	public function get($key) {
		if (!isset($this->registry[$key])) {
			throw new Exception("There is no entry for key " . $key);
		}

		return $this->registry[$key];
	}


	// array access

	public function offsetExists( $key ) {
		return isset($this->registry[$key]);
	}

	public function offsetGet ( $key ) {
		if(isset($this->registry[$key])) {
			return $this->registry[$key];
		}

		return null;
	}

	public function offsetSet ( $key , $value ) {
		return $this->registry[$key] = $value;
	}

	public function offsetUnset ( $key ) {
		unset($this->registry[$key]);
	}
}

?>