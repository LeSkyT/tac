<?php

$directories = array();

$files = scandir(__DIR__);
foreach($files as $file) {
  if (is_dir($file) && $file != "." && $file != "..") {
    $directories[] = __DIR__ . "/" . $file;
  }
} 

return $directories;
