<?php

namespace shgysk8zer0\Calendar\Abstracts;

abstract class Calendar extends \DateTime implements \JsonSerializable, \Serializable
{
	use \shgysk8zer0\Calendar\Traits\Magic;
}
