<?php

function scanFolder($dir) {
    $result = [];

    $contents = scandir($dir);
    foreach ($contents as $item) {
        if ($item != '.' && $item != '..') {
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $result[] = [
                    'name' => $item,
                    'type' => 'folder',
                    'contents' => scanFolder($path)
                ];
            } else {
                $result[] = [
                    'name' => $item,
                    'type' => 'image'
                ];
            }
        }
    }

    return $result;
}

$folderStructure = scanFolder('C:\xampp\htdocs\project\LS Instrument Website Images');

echo json_encode($folderStructure, JSON_PRETTY_PRINT);
?>