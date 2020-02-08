<?php
echo 'test';


//File path of final result
$filepath = "mergedfiles.txt";

$out = fopen($filepath, "w");
//Then cycle through the files reading and writing.

$filepathsArray = ['fileA.txt', 'fileB.txt'];

foreach ($filepathsArray as $file) {
    $in = fopen($file, "r");
    while ($line = fgets($in)) {
        print $file;
        fwrite($out, $line);
    }
    fclose($in);
}

//Then clean up
fclose($out);

return $filepath;