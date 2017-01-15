<?php

namespace shgysk8zer0\Calendar;
class Week extends Abstracts\Calendar implements \Iterator, \Countable
{
	use Traits\Iterator;

	public function count()
	{
		return 7;
	}

	final public function key()
	{
		return intval($this->format('w'));
	}
}
