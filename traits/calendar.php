<?php

namespace shgysk8zer0\Calendar\Traits;

use \shgysk8zer0\Calendar\Week as Week;
trait Calendar
{
	public function addCalendarToDOMEl(\DOMElement $parent)
	{
		$dom = $parent->ownerDocument;
		$table = $parent->appendChild($dom->createElement('table'));
		$table->appendChild($dom->createElement('caption', $this->{'F Y'}));
		$thead = $table->appendChild($dom->createElement('thead'));
		$tbody = $table->appendChild($dom->createElement('tbody'));
		$table->setAttribute('border', '1');
		$table->setAttribute('style', 'display: inline-block;');

		$tr = $thead->appendChild($dom->createElement('tr'));
		foreach (new Week as $day) {
			$td = $tr->appendChild($dom->createElement('th', $day->D));
			$td->setAttribute('bgcolor', '#777777');
		}

		$tr = $tbody->appendChild($dom->createElement('tr'));

		$this->rewind();
		for ($d = 0; $d < intval($this->format('w')); $d++) {
			$td =$tr->appendChild($dom->createElement('td', '&nbsp;'));
			$td->setAttribute('bgcolor', '#cfcfcf');
		}
		foreach ($this as $date) {
			$tr->appendChild(
				$dom->createElement('td', $date->j)
			)->setAttribute('title', json_encode(["$this" => $date], JSON_PRETTY_PRINT));

			if (intval($date->format('w')) === 6) {
				$tr = $tbody->appendChild($dom->createElement('tr'));
			}
		}

		for ($d = intval($this->format('w')); $d < 7; $d++) {
			$td = $tr->appendChild($dom->createElement('td', '&nbsp;'));
			$td->setAttribute('bgcolor', '#cfcfcf');
		}

		return $table;
	}

	public function getCalendarHTML()
	{
		$dom = new \DOMDocument();
		$body = $dom->appendChild($dom->createElement('body'));
		$calendar = $this->addCalendarToDOMEl($body);
		return $dom->saveHTML($calendar);
	}
}
