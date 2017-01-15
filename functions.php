<?php

namespace shgysk8zer0\Calendar\Functions;

use \shgysk8zer0\Calendar\Consts as Consts;
use \shgysk8zer0\Calendar\Month as Month;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'consts.php';

/**
 * Appends an element to $parent with optional text content and attributes
 * @param DOMElement $parent    Element to append to
 * @param String     $tagname   Tagname of element to append
 * @param String     $content   Optional text content
 * @param array      $attrs     Optional array of attributes to set on new element
 * @param array      $children  Optional array of arguments for children to create
 */
function add_element(
	\DOMElement $parent,
	String $tagname,
	String $content  = null,
	Array $attrs     = array(),
	Array $children  = array()
) : \DOMElement
{
	// Create the new element and append it to parent
	$el = new \DOMElement($tagname, $content);
	$parent->appendChild($el);

	// Set attributes on `$el` from the array of attributes
	array_map([$el, 'setAttribute'], array_keys($attrs), array_values($attrs));

	// Recursively call function with arguments from `$children`
	foreach ($children as $child) {
		// Child should be in the format:
		// String $tagname, [String $content, [Array $attrs, [Array $children]]]
		// `$el` is to be the $parent
		call_user_func(__FUNCTION__, $el, ...$child);
	}

	return $el;
}

/**
 * Gets arguments from `$_REQUEST`
 * @param void
 * @return Array [$count, $date]
 */
function get_args() : Array
{
	// Check for $count in `$_REQUEST` and verify that 1 >= $count <= 12
	if (array_key_exists(Consts\COUNT_KEY, $_REQUEST)) {
		$count = @intval($_REQUEST[Consts\COUNT_KEY]);
		if ($count < 1 or $count > 12) {
			$count = Consts\DEFAULTS['count'];
		}
	} else {
		$count = Consts\DEFAULTS['count'];
	}

	// Get $date ('Y-m') from `$_REQUEST` or set it to its default value
	if (
		array_key_exists(Consts\MONTH_KEY, $_REQUEST)
		and preg_match('/^\d{4}-\d{2}$/', $_REQUEST[Consts\MONTH_KEY])
	) {
		$date = $_REQUEST[Consts\MONTH_KEY];
	} else {
		$date = Consts\DEFAULTS['month'];
	}

	return [$count, $date];
}

/**
 * Appends calendar tables to a parent element
 * @param  DOMElement $parent Element to append calendar tables to
 * @return void
 */
function make_calendars(\DOMElement $parent)
{
	list($count, $date) = get_args();

	// Create a Month object and set its output format
	$month = new Month($date, new \DateTimeZone(Consts\TIMEZONE));
	$month->format = Consts\FORMAT;

	// Create $count calendar months / `<table>`s
	for ($i=0; $i <  $count; $i++) {
		$month->addCalendarToDOMEl($parent);
	}
}

/**
 * Builds the DOMDocument and returns it
 * @param  String $title The value for `<title>`
 * @return DOMDocument   <!DOCTYPE html><html>...
 */
function get_page_dom(String $title) : \DOMDocument
{
	// Build the HTML document
	$dom = new \DOMDocument(Consts\CHARSET);
	$dom->loadHTML('<!DOCTYPE html><html></html>');

	// Create `<head>` and append title & charset
	add_element($dom->documentElement, 'head', null, [], [
		['title', $title],
		['meta', null, ['charset' => Consts\CHARSET]],
	]);

	// Create `<body>` and append form & container for calendars
	add_element($dom->documentElement, 'body', null, [], [
		[
			'form',
			null,
			[
				'action' => '/',
			], [
				[
					'label',
					'Month',
					[
						'for' => 'month',
					]
				], [
					// Create input for month
					'input',
					null,
					[
						'name'        => Consts\MONTH_KEY,
						'type'        => 'month',
						'id'          => 'month',
						'pattern'     => '\d{4}-\d{2}',
						'placeholder' => 'YYYY-mm',
						'required'    => '',
					]
				], [
					'br'
				],
				[
					'label',
					'Count',
					[
						'for' => 'count',
					]
				], [
					// Create input for count
					'input',
					null,
					[
						'name' => Consts\COUNT_KEY,
						'id'   => 'count',
						'type' => 'range',
						'min'  => '1',
						'max'  => '12',
					]
				], [
					'br'
				], [
					// Create submit button
					'button',
					'Submit',
					[
						'type' => 'submit',
					],
				],
			]
		], [
			// This is the container for calendars
			'div', null, ['id' => 'calendars']
		],
	]);

	// Return the DOMDocument
	return $dom;
}

/**
 * Builds the HTML document and returns it as string
 * @param  String $title The value for `<title>`
 * @return String        <!DOCTYPE html><html>...
 */
function get_page(String $title) : String
{
	// Build the DOMDocument
	$dom = get_page_dom($title);

	// Append calendats to calendars container
	make_calendars($dom->getElementById('calendars'));

	// Return the DOMDocument as an HTML string
	return $dom->saveHTML();
}
