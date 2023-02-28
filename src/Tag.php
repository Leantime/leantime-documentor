<?php
/**
 * Tag
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   DigitalJoeCo\Leantime\Documentor
 */

namespace DigitalJoeCo\Leantime\Documentor;

use PhpParser\Node\Arg;

/**
 * Tag
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Tag {
	/**
	 * Name.
	 *
	 * @var string
	 */
	private string $name;

	/**
	 * Argument.
	 *
	 * @var Arg
	 */
	private Arg $arg;

    /**
	 * Method.
	 *
	 * @var string
	 */
	private string $method;

    /**
	 * Complete Hook.
	 *
	 * @var string
	 */
	private string $complete_hook;

	/**
	 * Construct hook.
	 *
	 * @param string $name   Name.
     * @param string $method Method.
	 * @param Arg    $arg    Argument.
	 */
	public function __construct( string $name, string $method, Arg $arg ) {
		$this->name = $name;
        $this->method = $method;
		$this->arg  = $arg;

        $this->constructHook();
	}

    private function constructHook()
    {
        $hook = '';

        if (!empty($this->method)) {
            $hook .= "{$this->method}.";
        }

        $this->complete_hook = $hook . $this->name;
    }

	/**
	 * Get name.
	 *
	 * @return string
	 */
	public function get_hook() {
		return $this->complete_hook;
	}
}
