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

	$start = new \DateTime('now', new \DateTimezone($timezone));
	$start->setTimezone(new \DateTimeZone(DATETIME_STORAGE_TIMEZONE));
	$start = DrupalDateTime::createFromDateTime($start);
	$formatted1 = \Drupal::service('date.formatter')->format($start->getTimestamp(), 'custom', 'Y-m-d');
	//echo $formatted1;
 
	$end = new \DateTime($datevalue, new \DateTimezone($timezone));
	$end->setTimezone(new \DateTimeZone(DATETIME_STORAGE_TIMEZONE));
	$end = DrupalDateTime::createFromDateTime($end);
	$formatted2 = \Drupal::service('date.formatter')->format($end->getTimestamp(), 'custom', 'Y-m-d');
	//echo $formatted2;

	$difference = $start->diff($end, true)->format("%a");

	if ($formatted1 == $formatted2) {
    	$ret = "This event is happening today.";
	}
	if($formatted1 < $formatted2) {
		$ret = 'Days left to event start: '.$difference;
	}
	if($formatted1 > $formatted2) {
		$ret = 'This event has passed.';
	}
	
	//$difference = $start->diff($end, true)->format("%a days");
	return $ret;
  }
}