<?php
function addPhoto($dir = '/')
{
    $folder_descriptor = opendir('data/');
    while(($row = readdir($folder_descriptor)) !== null)
    {
        echo $row;
    }
}

addPhoto();