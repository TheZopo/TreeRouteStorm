TreeRouteStorm
===
TreeRouteStorm is a router script for PHPStorm built-in web server that displays the files index like Apache web server do. It's allow you to have only one global configuration and easily navigate in your folders.

## Installation
TreeRouteStorm allows you to use a localy or remotly stored font and list of icons.
Download the `assets/` folder if you want to use the locally stored configuration.

* Place the script (and the assets folder) in your workspace directory.
* In PHPStorm navigate to `Run > Edit Configurations` and create a new PHP Built-in Web Server.
* Choose the `Document Root` as your workspace directory.
* Check `Use rooter script` and select `TreeRouteStorm.php` in your workspace directory.

## Configuration
Configure TreeRouteStorm by changing the constants at the start of the script file.

|Setting name|Meaning |
|---|---|
|`LANGAGE_CODE`|Your language code according to BCP47|
|`PAGE_TITLE`|The title of index pages|
|`PARENT_DIRECTORY`|A string that identify the parent directory|
|`SCRIPT_FILENAME`|Filename of the file that contains TreeRouteStorm|
|`ROOT_DIR`|The absolute path to the built-in web server root|

### Icons configuration
TreeRouteStorm allows you to use a custom list of icons for each extension. This list of icons can be located locally or on a remote server. In this case you have to specify to the script a file containing the list of available extensions icons, one per line.

For the icons configuration pleases edit these settings:

|Setting name|Meaning|
|---|---|
|`ASSETS_DIR`|The relative path to the assets folder containings icons and the font in case of a local configuration. The URL to the icons folder instead|
|`ICONS_EXTENSION`|The icons extension according to the HTML `img` tag capabilities|
|`REMOTE_USE`|True if you choose the remote server configuration, false instead|
|`EXT_LIST_PATH`|In case of a remote server configuration, path to a file containing all the extensions available, one per line|


