<?php

namespace shgysk8zer0\Calendar;
class Month extends Abstracts\Calendar implements \Iterator, \Countable, Interfaces\Calendar
{
	use Traits\Iterator;
	use Traits\Calendar;

	public function count()
	{
		return intval($this->format('t'));
	}

	final public function key()
	{
		return intval($this->format('j')) -1;
	}
}
