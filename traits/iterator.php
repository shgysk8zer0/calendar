<?php

namespace shgysk8zer0\Calendar\Traits;

trait Iterator
{
	private $_day_counter = 1;
	private $_max_days;


	final public function current()
	{
		return $this;
	}

	final public function next()
	{
		$this->modify('+1 day');
	}

	// Does not handle end of month.
	final public function valid()
	{
		$more = $this->_day_counter++ <= $this->_max_days;
		if (!$more) {
			$this->modify('-1 day');
		}
		return $more;
	}

	final public function rewind()
	{
		$this->_max_days = count($this);
		$this->modify("- {$this->key()} days");
		$this->_day_counter = 1;
	}
}
