<?php

namespace shgysk8zer0\Calendar\Interfaces;
interface Calendar
{
	public function addCalendarToDOMEl(\DOMElement $parent);

	public function getCalendarHTML();
}
