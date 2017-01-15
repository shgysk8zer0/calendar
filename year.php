<?php

namespace shgysk8zer0\Calendar;
class Year extends Abstracts\Calendar implements \Iterator, \Countable
{
	use Traits\Iterator;

	public function count()
	{
		return $this->format('L') === '1' ? 366 : 365;
	}

	final public function key()
	{
		return intval($this->format('z'));
	}
}
