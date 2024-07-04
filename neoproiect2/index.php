<?php

$startTime = microtime(true); 

$limit = 10;
$offset = 0;
$search = ''; 

if (isset($_GET['limit'])) {
    $limit = (int) $_GET['limit'];
}
if (isset($_GET['offset'])) {
    $offset = (int) $_GET['offset'];
}
if (isset($_GET['search'])) { 
    $search = $_GET['search'];
}

$CSVvar = fopen("netflix_titles.csv", "r");
if ($CSVvar!== FALSE) {
?>
	<html>
	<head>
		<style>
			table,th,td {
				border: 2px solid black;
			}
		</style>
	</head>
	<div>
		<form>
			<label for="limit">Limit:</label>
			<input type="number" id="limit" name="limit" value="<?php echo $limit;?>">
			<label for="offset">Offset:</label>
			<input type="number" id="offset" name="offset" value="<?php echo $offset;?>">
			<label for="search">Search:</label>
			<input type="text" id="search" name="search" value="<?php echo $search;?>">
			<button type="submit">Apply</button>
		</form>
		<table style="border:1px solid black">
<?php
	$rowCount = 0;
	$resultCount = 0; 
	while (! feof($CSVvar)) {
		$data = fgetcsv($CSVvar, 1000, ",");
		if (! empty($data)) {
			if (stripos($data[2], $search)!== false) { 
				if ($rowCount >= $offset && $rowCount < $offset + $limit) {
					?>
					<tr>
						<td><?php echo $data[0];?></td>
						<td><?php echo $data[1];?></td>
						<td><?php echo $data[2];?></td>
						<td><?php echo $data[3];?></td>
						<td><?php echo $data[4];?></td>
						<td><?php echo $data[5];?></td>
						<td><?php echo $data[6];?></td>
						<td><?php echo $data[7];?></td>
						<td><?php echo $data[8];?></td>
						<td><?php echo $data[9];?></td>
						<td><?php echo $data[10];?></td>
						<td><?php echo $data[11];?></td>
					</tr>
					<?php
					$resultCount++;
				}
			}
			$rowCount++;
		}
	}
?>
		</table>
		<p>Search results: <?php echo $resultCount;?> (Page loaded in <?php echo round(microtime(true) - $startTime, 4);?> seconds.)</p>
	</div>
	</html>
<?php
}
fclose($CSVvar);
?>