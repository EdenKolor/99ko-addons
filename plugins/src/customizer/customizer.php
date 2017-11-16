<?php

defined('ROOT') OR exit('No direct script access allowed');

## Fonction d'installation

function customizerInstall() {
    
}

## Hooks

function customizerCoreGetConfigVal() {
    $str = 
        "if (\$k == 'theme' && isset(\$_GET[\$k])) {"
        . "\$themes = core::getInstance()->getThemes();"
        . "if (in_array(trim(\$_GET[\$k]), array_keys(\$themes))) {"
        . "     \$this->config[\$k] = \$_GET[\$k];"
        . "}}";

    return $str;
}

function customizerCoreGetThemes() {
    $str = 
        "\$temp = util::scanDir(THEMES);"
        . "foreach(\$temp['dir'] as \$k=>\$v){"
        . "     \$this->themes[\$v] = util::readJsonFile(THEMES.\$v.'/infos.json', true);"
        . "}";
    
    return $str;
}

## Code relatif au plugin

function install_theme() {
    if ($_FILES["zip_file"]["name"]) {
        $filename = $_FILES["zip_file"]["name"];
        $source = $_FILES["zip_file"]["tmp_name"];
        $type = $_FILES["zip_file"]["type"];

        $name = explode(".", $filename);
        $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
        foreach ($accepted_types as $mime_type) {
            if ($mime_type == $type) {
                $okay = true;
                break;
            }
        }

        $continue = strtolower($name[1]) == 'zip' ? true : false;
        if (!$continue) {
            return "le fichier n'est pas un .zip";
        }

        $targetdir = THEMES; // targeted theme directory
        $targetzip = UPLOAD . $filename; // targeted zip file

        $filenoext = basename ($filename, '.zip');  // remove ext from filename (when lowercase)
        $filenoext = basename ($filenoext, '.ZIP');  // remove ext from filename (when uppercase)
        
        if (is_dir($targetdir.$filenoext))
            rmdir_recursive($targetdir.$filenoext);

        //mkdir($targetdir, 0777);

        if (move_uploaded_file($source, $targetzip)) {
            $zip = new ZipArchive();
            $x = $zip->open($targetzip);  // open the zip file to extract
            if ($x === true) {
                $zip->extractTo($targetdir); // place in the directory with same name  
                $zip->close();

                unlink($targetzip);
            }
            return "success";
        } else {
            return "copie du thème impossible";
        }
    }
}

function rmdir_recursive($dir) {
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file)
            continue;
        if (is_dir("$dir/$file"))
            rmdir_recursive("$dir/$file");
        else
            unlink("$dir/$file");
    }

    rmdir($dir);
}

?>