<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$target =  __DIR__."../system/storage/app/public";
$link = __DIR__."/storage";
echo $link;

if (!file_exists($target)) {
    die("The target directory does not exist: $target");
}

if (file_exists($link)) {
    if (is_link($link)) {
        unlink($link);
    } else {
        rmdir($link);
    }
}

if (symlink($target, $link)) {
    echo "Symlink created successfully!";
} else {
    echo "Failed to create symlink.";
}

?>
