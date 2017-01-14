<?php

namespace shgysk8zer0\Calendar\Traits;

trait Magic
{

	final public function __toString()
	{
		return $this->format($this->format);
	}

	public function __get($format)
	{
		return $this->format($format);
	}

	public function __invoke($offset)
	{
		return $this->modify($offset);
	}

	public function __debugInfo()
	{
		return [
			'Year'  => intval($this->format('Y')),
			'Month' => intval($this->format('n')),
			'Day'   => intval($this->format('j')),
		];
	}

	public function serialize()
	{
		return serialize([
			'y'   => intval($this->format('Y')),
			'm'   => intval($this->format('n')),
			'd'   => intval($this->format('j')),
			'f'   => $this->format,
		]);
	}

	public function unserialize($data)
	{
		$data = unserialize($data);
		$this->format = $data['f'];
		$this->setDate($data['y'], $data['m'], $data['d']);
	}

	public function jsonSerialize()
	{
		return [
			'year' => intval($this->format('Y')),
			'month' => [
				'name'    => $this->format('F'),
				'abbr'    => $this->format('M'),
				'number'  => intval($this->format('n')),
				'numDays' => intval($this->format('t')),
			],
			'day' => [
				'name'    => $this->format('l'),
				'abbr'    => $this->format('D'),
				'ofWeek'  => intval($this->format('w')) + 1,
				'ofMonth' => intval($this->format('j')),
				'ofYear'  => intval($this->format('z')) + 1,
				'suffix'  => $this->format('S'),
			],
			'weekNumber'           => intval($this->format('W')),
			'timezone'             => $this->getTimezone()->getName(),
			'timezoneOffset'       => $this->format('O'),
			'timestamp'            => $this->getTimestamp(),
			'isDaylightSavingTime' => $this->format('I') === '1',
			'isLeapYear'           => $this->format('L') === '1',
		];
	}
}
