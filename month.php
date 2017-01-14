<?php

namespace shgysk8zer0\Calendar;
class Month extends \DateTime implements \Iterator, \JsonSerializable, \Countable, \Serializable
{
	use Traits\Iterator;
	use Traits\Magic;

	public $format = 'Y-m-d';

	public function count()
	{
		return intval($this->format('t'));
	}

	final public function key()
	{
		return intval($this->format('j'));
	}
}

