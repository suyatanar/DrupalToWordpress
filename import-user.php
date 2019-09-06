<?php

$row = 1;
$plugin_dir = plugin_dir_url( __FILE__ );
$csv_file = $plugin_dir."uploads/user.csv";
$csv = array_map('str_getcsv', file($csv_file));
array_walk($csv, function(&$a) use ($csv) {
  $a = array_combine($csv[0], $a);
});
array_shift($csv); # remove column header

// var_dump($a);
$file = fopen($csv_file, 'r');
while (($line = fgetcsv($file, "" , ",")) !== FALSE) {
    $csv = array_map('str_getcsv', file($csv_file));
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($csv[0], $a);
  });
array_shift($csv); # remove column heade

//$csv = array_shift($csv);
// $csv = array_filter($csv, function($v, $k) {
//     return $k != '' && $v != '';
// }, ARRAY_FILTER_USE_BOTH);
}
fclose($file);

$c = function($v){
    return array_filter($v) != array();
};
$get_data = array_filter($csv, $c);
//var_dump($get_data);

foreach ($get_data as $get_data) {
	var_dump($get_data);

	
}