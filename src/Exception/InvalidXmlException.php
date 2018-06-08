<?php

namespace MaciejKosiarski\XmlFinder\Exception;

/**
 * Class InvalidXmlException
 * @package MaciejKosiarski\XmlFinder\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class InvalidXmlException extends \Exception
{
	public function __construct($extension)
	{
		parent::__construct(sprintf('Invalid source data file (.%s).', $extension));
	}
}