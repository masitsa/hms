<?php
  // Set timezone
  date_default_timezone_set("UTC");
 
  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
class Dates{
	
  function dateDiff($time1, $time2, $interval) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    if (!in_array($interval, $intervals)) {
      return false;
    }
 
    $diff = 0;
    // Create temp time from time1 and interval
    $ttime = strtotime("+1 " . $interval, $time1);
    // Loop until temp time is smaller than time2
    while ($time2 >= $ttime) {
      $time1 = $ttime;
      $diff++;
      // Create new temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
    }
 
    return $diff;
  }
}
  /*echo "Timestamps 2011-12-16 00:00 - 2011-12-17 00:00<br/>";
  echo "Hour interval: " . dateDiff('2011-12-16 00:00', '2011-12-17 00:00', 'hour') . "<br/>";
  echo "Day interval: " . dateDiff('2011-12-16 00:00', '2011-12-17 00:00', 'day') . "<br/>";
  echo "Month interval: " . dateDiff('2011-11-16 00:00', '2011-12-17 00:00', 'month') . "<br/>";
  echo "Year interval: " . dateDiff('2015-12-16 00:00', '2011-12-17 00:00', 'year') . "<br/>";*/
 
?>