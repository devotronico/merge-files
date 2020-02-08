<?php

/**
 * Ritorna lista di file e cartelle
 *
 * @param [type] $dir
 * @param array $results
 * @return void
 */
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


/**
 * UNISCE I FILE IN UN UNICO FILE
 * [a] File path of final result
 * [b] crea e apre il file
 * [c] cicla la lista di file e cartelle
 * @param [type] $filepathsArray
 * @return void
 */
function mergeFiles($filepathsArray)
{
    $filepath = "mergedfiles.txt"; // [a]
    $out = fopen($filepath, "w"); // [b]
    foreach ($filepathsArray as $file) { // [c]
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
            $in = fopen($file, "r");
            while ($line = fgets($in)) {
                // print $file . '<br>'; // DEBUG
                fwrite($out, $line);
            }
            fclose($in);
        }
    }
    fclose($out); // chiude e pulisce

    return $filepath;
}



$filepathsArray = getDirContents('C:/xampp_7.4.1/htdocs/merge-file/public');
// $filepathsArray = array_reverse($filepathsArray);
// echo '<pre>';
// var_dump($filepathsArray);
// echo '</pre>';
// die;
mergeFiles($filepathsArray);