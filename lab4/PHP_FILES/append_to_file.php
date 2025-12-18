<?php
$file_path = 'newfile.txt';
$new_content = "Another note added here.\n";

// Open the file in append mode ('a') or read/append ('a+')
$handle = fopen($file_path, 'a') or die("Unable to open file!");

// Write the data to the file
fwrite($handle, $new_content);

// Close the file handle
fclose($handle);

echo "Content appended successfully using fopen/fwrite.";
?>