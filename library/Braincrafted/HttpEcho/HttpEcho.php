<?php
/**
 * @package HttpEcho
 */

namespace Braincrafted\HttpEcho;

/**
 * HttpEcho is a simple web service that returns the request. It is useful to debug requests.
 *
 * @package HttpEcho
 * @author {@link http://florianeckerstorfer.com Florian Eckerstorfer}
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License v3
 */
class HttpEcho
{
	
	/** @var array */
	protected $serverParameters = array();
	
	/** @var array */
	protected $getParameters = array();
	
	/** @var array */
	protected $postParameters = array();
	
	/** @var array */
	protected $cookies = array();
	
	/**
	 * Constructor.
	 *
	 * @param array $serverParameters Array with with server parameters.
	 * @param array $getParameters Array with get parameters.
	 * @param array $postParameters Array with post parameters.
	 */
	public function __construct(array $serverParameters, array $getParameters, array $postParameters, array $cookies)
	{
		$this->serverParameters = $serverParameters;
		$this->getParameters	= $getParameters;
		$this->postParameters	= $postParameters;
		$this->cookies			= $cookies;
	}
	
	/**
	 * Returns the request info in plain text.
	 *
	 * @return string Request info in plain text.
	 */
	public function asText()
	{
		$output = '';
		foreach ($this->getRequestInfo() as $name => $value)
		{
			$output .= str_pad($name . ':', 24) . ' ';
			if (is_array($value) && count($value) > 0)
			{
				$i = 0;
				foreach ($value as $key => $valueValue)
				{
					if ($i > 0)
					{
						$output .= str_repeat(' ', 25);
					}
					$output .= str_pad($this->formatValue($key), 20) . '=> ' . $this->formatValue($valueValue) . "\n";
					++$i;
				}
			}
			elseif (is_array($value))
			{
				$output .= "[no values]\n";
			}
			else
			{
				$output .= $this->formatValue($value) . "\n";
			}
		}
		return $output;
	}
	
	/**
	 * Returns the request info as an array.
	 *
	 * @return array Array with request info.
	 */
	protected function getRequestInfo()
	{
		$info = array(
			'REQUEST_METHOD'	=> $this->serverParameters['REQUEST_METHOD'],
			'QUERY_STRING'		=> $this->serverParameters['QUERY_STRING'],
			'REQUEST_URI'		=> $this->serverParameters['REQUEST_URI'],
			'REQUEST_TIME'		=> $this->serverParameters['REQUEST_TIME'],
			'GET_PARAMETERS'	=> $this->getParameters,
			'POST_PARAMETERS'	=> $this->postParameters,
			'COOKIES'			=> $this->cookies,
		);
		foreach ($this->serverParameters as $key => $value)
		{
			if (substr($key, 0, 5) == 'HTTP_')
			{
				$info[$key] = $value;
			}
		}
		return $info;
	}
	
	/**
	 * Formats the given value.
	 *
	 * @param mixed $value Value.
	 * @return string Formatted value.
	 */
	protected function formatValue($value)
	{
		if (is_bool($value))
		{
			return $value ? 'TRUE' : 'FALSE';
		}
		elseif (is_string($value))
		{
			return '"' . addslashes($value) . '"';
		}
		else if (is_null($value))
		{
			return 'NULL';
		}
		else
		{
			return $value;
		}
	}
	
}