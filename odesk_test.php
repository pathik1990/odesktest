<?php

 
$asc_array = array(
	array(
		'Name' => 'Trixie',
		'Color' => 'Green',
		'Element' => 'Earth',
		'Likes' => 'Flowers'
	),
	array(
		'Name' => 'Tinkerbell',
		'Element' => 'Air',
		'Likes' => 'Singing',
		'Color' => 'Blue'
	),
	array(
		'Element' => 'Water',
		'Likes' => 'Dancing',
		'Name' => 'Blum',
		'Color' => 'Pink'
	),
);
 
function make_acii_table($asc_array){
 	echo "<style> .column1{background: red;} .column2{background:green;} .column3{background:blue;} .column4{background:orange;} span{background:grey;color:white;} </style>";
	$newline = "\n";
	$headers = array_keys(reset($asc_array));
	
	$lengths = array();
	foreach($headers as $header)
	{
		$header_length = strlen($header);
		$max = $header_length;
		foreach($asc_array as $row)
		{
			$length = strlen($row[$header]);
			if($length > $max)
				$max = $length;
		}
 
		if(($max % 2) != ($header_length % 2))
			$max += 1;
 
		$lengths[$header] = $max;
	}
	
	$row = '';
	foreach($lengths as $column_length)
	{
		$row .= '+' . str_repeat('-', (1 * 2) + $column_length);
	}
	$row .= '+';
	
	$rseparator = $row;
	
	$row1 = '';
	foreach($lengths as $column_length)
	{
		$row1 .= '|' . str_repeat(' ', (1 * 2) + $column_length);
	}
	$row1 .= '|';
 
	
	
	$rspacer = $row1;
	
	$row3 = '';
	$row3 = "<span>";
	foreach($headers as $header)
	{
		$row3 .= '|' . str_pad($header, (1 * 2) + $lengths[$header], ' ', STR_PAD_BOTH);
	}
	$row3 .= '|';
	
	$row3 .= "</span>";
 
	
	$rheaders = $row3;
 
	echo '<pre>';
 
		echo $rseparator . $newline;
		echo str_repeat($rspacer . $newline, 0);
		echo $rheaders . $newline;
		echo str_repeat($rspacer . $newline, 0);
		echo $rseparator . $newline;
		echo str_repeat($rspacer . $newline, 0);
		foreach($asc_array as $row_cells)
		{
			$row4 = '';
				$i = 1;
				foreach($headers as $header)
				{
					$row4 .= '|' . '<span class="column'.$i.'">' . str_repeat(' ', 1) . str_pad($row_cells[$header], 1 + $lengths[$header], ' ', STR_PAD_RIGHT). '</span>';
				$i++;
				}
				$row4 .= '|';
 
			$row_cells = $row4;
			echo $row_cells . $newline;
			echo str_repeat($rspacer . $newline, 0);
		}
		echo $rseparator . $newline;
 
	echo '</pre>';
 
}
 
make_acii_table($asc_array);
