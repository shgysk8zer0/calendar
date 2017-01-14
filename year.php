<?php

namespace shgysk8zer0\Calendar;
class Year extends \DateTime implements \Iterator, \JsonSerializable,\ Countable, \Serializable
{
	use Traits\Iterator;
	use Traits\Magic;

	public $format = 'Y-m-d';

	public function count()
	{
		return $this->format('L') === '1' ? 366 : 365;
	}

	final public function key()
	{
		return intval($this->format('z'));
	}
}

