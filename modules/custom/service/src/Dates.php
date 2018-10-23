<?php
/**
 * @file
 * Contains Drupal\service\Dates.
 */
namespace Drupal\service;

use Drupal\Core\Datetime\DrupalDateTime;
/**
 * Class Dates.
 *
 * @package Drupal\Dates
 */
class Dates {
  public function compareDates($datevalue) {
	// $createDate = new DateTime('$datevalue');

	// $strip = $createDate->format('Y-m-d');

	// $now = new DateTime();
	// $difference = $now->diff($createDate, true)->format("%a days");
	//var_dump($difference);
	//$fieldDate = new DateObject($datevalue, date_default_timezone(), DATE_FORMAT_ISO);
	$timezone = drupal_get_user_timezone();

	$start = new \DateTime('now', new \DateTimezone('UTC'));
	$start->setTimezone(new \DateTimeZone(DATETIME_STORAGE_TIMEZONE));
	$start = DrupalDateTime::createFromDateTime($start);
	$formatted1 = \Drupal::service('date.formatter')->format($start->getTimestamp(), 'custom', 'Y-m-d at H:m:s');
	//echo $formatted1;
 
	$end = new \DateTime($datevalue, new \DateTimezone('UTC'));
	$end->setTimezone(new \DateTimeZone(DATETIME_STORAGE_TIMEZONE));
	$end = DrupalDateTime::createFromDateTime($end);
	$formatted2 = \Drupal::service('date.formatter')->format($end->getTimestamp(), 'custom', 'Y-m-d at H:m:s');
	//echo $formatted2;
	//echo $time2;
	//echo $time1;
	//echo $start;
	//echo $end;

	$difference = $start->diff($end, true);
	$hours = $difference->h + ($difference->days * 24); 

	if ($formatted1 == $formatted2) {
    	$ret = "This event is happening today.";
	}
	if($formatted1 < $formatted2) {
		if($hours < 24) {
			$ret = 'Days left to event start: '.$hours.' hours';
		}
		else {
			$ret = 'Days left to event start: '.$difference->format('%a');
		}
	}
	if($formatted1 > $formatted2) {
		$ret = 'This event has passed.';
	}
	
	//$difference = $start->diff($end, true)->format("%a days");
	return $ret;
  }
}