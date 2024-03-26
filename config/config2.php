<?php

// set document root folder to public
define('ROOT_FOLDER', 'public');

$this_folder = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));
$parent_folder = dirname($this_folder);
// echo '<br>';
// echo 'DOCUMENT_ROOT: ' . $_SERVER['DOCUMENT_ROOT'];
// echo '<br>';
// echo '__DIR__: ' . __DIR__;
// echo '<br>';
// echo 'this_folder: ' . $this_folder;
// echo '<br>';
// echo 'parent folder: ' . $parent_folder;
// echo '<br>';
// define('DOC_ROOT', $parent_folder . DIRECTORY_SEPARATOR . ROOT_FOLDER . DIRECTORY_SEPARATOR);
// echo 'DOC_ROOT: ' . DOC_ROOT;
// echo '<br>';

// database setting
$type = 'mysql';
$server = 'localhost';
$dbname = 'themobilehour';
$port = '3307';
$charset = 'utf8mb4';
$username = 'root';
$password = '';

// create DSN
$dsn = "$type:host=$server;dbname=$dbname;port=$port;charset=$charset";

// File upload setting
define('IMAGE_UPLOADS', dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);
define('DOCUMENT_UPLOADS', dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR);
define('AVATAR_UPLOADS', dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR);
// echo 'image_uploads_folder: ' . IMAGE_UPLOADS;
// echo '<br>';
// echo 'documents_uploads_folder: ' . DOCUMENT_UPLOADS;
// echo '<br>';
// echo 'avatars_uploads_folder: ' . AVATAR_UPLOADS;
