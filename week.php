<?php

namespace shgysk8zer0\Calendar;
class Week extends \DateTime implements \Iterator, \JsonSerializable, \Countable, \Serializable
{
	use Traits\Iterator;
	use Traits\Magic;

	public $format = 'Y-m-d';

	public function count()
	{
		return 7;
	}

	final public function key()
	{
		return intval($this->format('w'));
	}
}

