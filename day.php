<?php

namespace shgysk8zer0\Calendar;
class Day extends \DateTime implements \JsonSerializable, \Serializable
{
	use Traits\Magic;

	public $format = 'Y-m-d';
}

