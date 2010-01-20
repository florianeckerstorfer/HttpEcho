<?php

namespace Braincrafted\HttpEcho;

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
					$output .= str_pad((is_string($key) ? '"' : '') . $key . (is_string($key) ? '"' : ''), 20) . '=> '
							. (is_string($valueValue) ? '"' : '') . $valueValue . (is_string($valueValue) ? '"' : '')
							. "\n";
					++$i;
				}
			}
			elseif (is_array($value))
			{
				$output .= "[no values]\n";
			}
			elseif (is_bool($value))
			{
				$output .= ($value ? 'TRUE' : 'FALSE') . "\n";
			}
			elseif (is_null($value))
			{
				$output .= "NULL\n";
			}
			elseif (is_string($value))
			{
				$output .= "\"" . $value . "\"\n";
			}
			else
			{
				$output .= $value . "\n";
			}
		}
		return $output;
	}
	
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
	
}