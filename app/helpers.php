<?php
if (! function_exists('edate')) {
    function edate($date)
    {
		$now = new DateTime();
		$let = new DateTime($date);

		$interval = $now->diff($let);

		return $interval->format("%a napja, %h órája, %i perce");
    }
}

if (! function_exists('writestat')) {
    function writestat($stat)
    {
		$stats = array(
			'nyitott',
			'lezárt'
		);

		return $stats[$stat];
    }
}