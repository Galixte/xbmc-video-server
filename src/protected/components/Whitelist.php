<?php

/**
 * Application component that keeps track of the current access whitelist and 
 * provides a way to check the client against it.
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2013-
 * @license https://www.gnu.org/licenses/gpl.html The GNU General Public License v3.0
 */
class Whitelist extends CApplicationComponent
{

	/**
	 * @var \Whitelist\Check the whitelist checker
	 */
	private $_checker;

	/**
	 * @var boolean indicates whether the whitelist should be consulted or not
	 */
	private $_isActive = false;

	/**
	 * Initializes the component
	 */
	public function init()
	{
		$this->_checker = new Whitelist\Check();

		// Load any stored definitions
		$definitions = Setting::getString('whitelist');

		if (!empty($definitions))
		{
			$definitions = $this->parseDefinitions($definitions);
			$this->setDefinitions($definitions);
		}

		parent::init();
	}

	/**
	 * Parses a comma-separated string of definitions into an array
	 * @param string $definitions the definition string
	 * @return array
	 */
	public function parseDefinitions($definitions)
	{
		return explode(',', $definitions);
	}

	/**
	 * Activates the whitelist with the specified definitions
	 * @param array $definitions the definitions
	 */
	public function setDefinitions($definitions)
	{
		$this->_checker->whitelist($definitions);
		$this->_isActive = true;
	}

	/**
	 * Validates the specified conditions
	 * @param array $definitions the definitions
	 * @return boolean whether the definition set is legal or not
	 */
	public function validateDefinitions($definitions)
	{
		$temporaryChecker = clone $this->_checker;

		try
		{
			$temporaryChecker->whitelist($definitions);
		}
		catch (Exception $e)
		{
			unset($e);
			return false;
		}

		return true;
	}

	/**
	 * Checks the client address and/or hostname against the whitelisted. The 
	 * check is omitted if no whitelist definitions have been specified or if 
	 * the override file is present.
	 * @param boolean $ignoreOverride whether to honor the override file when 
	 * checking.
	 * @return boolean whether the client is whitelisted or not
	 */
	public function check($ignoreOverride = false)
	{
		if (!$this->_isActive)
			return true;
		
		// Discard the check if the override file is present or if the 
		// whitelist is inactive
		$overrideFile = Yii::app()->basePath.'/../../whitelist.override';
		
		if (!$ignoreOverride && file_exists($overrideFile))
		{
			Yii::app()->user->setFlash('info', 'Whitelist override in effect');
			return true;
		}

		$address = $_SERVER['REMOTE_ADDR'];
		$hostname = gethostbyaddr($address);

		$whitelisted = $this->_checker->check($address);

		if (!$whitelisted && $hostname !== false && $hostname !== $address)
			$whitelisted = $this->_checker->check($hostname);

		return $whitelisted;
	}

}
