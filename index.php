<?php

function getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}


/// UNISCI I FILE IN UN UNICO FILE
function mergeFiles($filepathsArray)
{
    $filepath = "mergedfiles.txt"; // File path of final result
    $out = fopen($filepath, "w");
    foreach ($filepathsArray as $file) {
        if (preg_match('/^.+\.(txt|js|css|php)$/', $file)) {
            $path = dirname($file);
            $baseName = basename($file);
            $folder =  explode('merge-file\\', $path)[1];
            $header = <<<EOD
----------------
cartella: $folder
file: $baseName
----------------
EOD;
            $header = PHP_EOL . PHP_EOL . $header . PHP_EOL;

            fwrite($out, $header);
            // fwrite($out, $baseName);
            $in = fopen($file, "r");
            while ($line = fgets($in)) {
                print $file;
                echo '<br>';
                fwrite($out, $line);
            }
            fclose($in);
        }
    }
    fclose($out); //Then clean up

    return $filepath;
}



$filepathsArray = getDirContents('C:/xampp_7.4.1/htdocs/merge-file/public');
// $filepathsArray = array_reverse($filepathsArray);
// echo '<pre>';
// var_dump($filepathsArray);
// echo '</pre>';
// die;
mergeFiles($filepathsArray);