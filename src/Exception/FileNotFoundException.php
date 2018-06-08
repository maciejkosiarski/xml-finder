<?php

namespace MaciejKosiarski\XmlFinder\Exception;

/**
 * Class FileNotFoundException
 * @package MaciejKosiarski\XmlFinder\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class FileNotFoundException extends \Exception
{
	public function __construct()
	{
		parent::__construct('File not found exception');
	}
}