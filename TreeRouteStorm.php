<?php
/* Router script for PHPStorm built-in web server
 * Version 1.0
 *
 * Copyright 2017, Bastien Marsaud
 * http://bastien-marsaud.fr
 *
 * Licensed under the Creative Commons BY NC ND 3.0 license:
 * https://creativecommons.org/licenses/by-nc-nd/3.0/
 *
 * Default configuration icons are desiged by Smashicons
 * Under Flat Icon Basic Licence
 * https://file000.flaticon.com/downloads/license/license.pdf
 */
    //--- CONFIGURATION ---
    //Read README.md for help
    define("LANGAGE_CODE", "en");
    define("PAGE_TITLE", "Files index");
    define("INDEX_OF", "Index of ");
    define("PARENT_DIRECTORY", "Parent directory...");

    define("SCRIPT_FILENAME", "TreeRouteStorm.php");
    define("ROOT_DIR", "C:/PATH/TO/YOUR/WORKSPACE");
    define("ASSETS_DIR", "http://bastien-marsaud.fr/resources/TreeRouteStorm/icons");
    define("ICONS_EXTENSION", "png");

    define("REMOTE_USE", true);
    define("EXT_LIST_PATH", ASSETS_DIR."/list.php");
    //--- CONFIGURATION END ---


    if(REMOTE_USE) $extensions = explode("\n", file_get_contents(EXT_LIST_PATH));

    //Define path vars
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $absPath = ROOT_DIR.$path;

    //If the requested ressource is a file, we serve it as-is
    if (!is_dir($absPath)) {
        return false;
    }

    //If the url requested is typped manually and there is no / at the end we add it
    if(substr($path, -1) != '/') {
        $path .= '/';
        $absPath .= '/';
    }

    //Get files list
    $dirs = scandir($absPath);

    //If the requested directory contains an index we serve it.
    if(preg_grep(';index\..*;', $dirs)) {
       return false;
    }

    //Hiding the file type icons directory
    if(!REMOTE_USE && in_array(basename(ASSETS_DIR), $dirs) && $path == str_replace("\\", "", dirname(ASSETS_DIR))."/") {
        unset($dirs[array_search(basename(ASSETS_DIR), $dirs)]);
    }

    //Hiding unrelevant file names
    unset($dirs[array_search('.', $dirs)]);
    unset($dirs[array_search('..', $dirs)]);
    unset($dirs[array_search(SCRIPT_FILENAME, $dirs)]);
?>

<!DOCTYPE html>
<html lang="<?=LANGAGE_CODE?>">
    <head>
        <meta charset="utf-8" />
        <title><?=PAGE_TITLE?></title>

        <style type="text/css">
            <?php if(REMOTE_USE) echo "@import url('https://fonts.googleapis.com/css?family=Open+Sans');";
            else {
                echo '@font-face {';
                echo '    font-family: "Open Sans";';
                echo '    src: url('.ASSETS_DIR.'/OpenSans-Regular.ttf);';
                echo '}';
            } ?>

            body {
                font-family: "Open Sans", sans-serif;
                font-size: 16px;
            }

            h1 {
                font-size: 1.5em;
                margin-bottom: 0.2em;
            }

            hr {
                margin-bottom: 0.8em;
            }

            img {
                width: 24px;
                height: 24px;
                margin-right: 0.5em;

                vertical-align: middle;
            }

            ul {
                list-style: none;
                margin: 0.4em 0;
            }

            ul li {
                margin: 0.2em 0;
            }
        </style>
    </head>
    <body>
        <h1><?=INDEX_OF.$path?></h1>
        <hr />
        <img src="<?=ASSETS_DIR?>/parent.<?=ICONS_EXTENSION?>" /><a href="<?=substr($path, -1) == "/" ? "$path.." : "$path/.." ?>"><?=PARENT_DIRECTORY?></a>
        <ul>
            <?php
                foreach($dirs as $dir) {
                    $targetAbsPath = $absPath.$dir;
                    $slash = is_dir($targetAbsPath) ? '/' : '';
                    $ext = pathinfo($dir, PATHINFO_EXTENSION);

                    if(is_dir($targetAbsPath)) $iconPath = ASSETS_DIR."/folder.".ICONS_EXTENSION;
                    elseif(REMOTE_USE && $ext != NULL && in_array($ext, $extensions)) $iconPath = ASSETS_DIR."/$ext.".ICONS_EXTENSION;
                    elseif(!REMOTE_USE && file_exists(ROOT_DIR.ASSETS_DIR."/$ext.".ICONS_EXTENSION)) $iconPath = ASSETS_DIR."/$ext.".ICONS_EXTENSION;
                    else $iconPath = ASSETS_DIR."/file.".ICONS_EXTENSION;

                    echo "<li><img src='$iconPath' /><a href='$path$dir$slash'>$dir</a></li>";
                }
                ?>
        </ul>
    </body>
</html>
