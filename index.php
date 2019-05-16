<?php
function adminer_object() {
    if (!isset($_SESSION["design"])) {
        $_SESSION["design"] = './designs/lucas-sandery/adminer.css';
    }
    // required to run any plugin
    include_once "./plugins/plugin.php";

    // autoloader
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }
    $designDirs = scandir('designs');
    $designs = [];
    foreach ($designDirs as $design) {
        if($design != '.' && $design != '..')
        $designs['./designs/' . $design . '/adminer.css'] = $design;
    }
    $plugins = [
        // specify enabled plugins here
        new AdminerDatabaseHide([]),
        new AdminerDesigns($designs),
        new AdminerDumpAlter(),
        new AdminerDumpZip(),
        new AdminerEditTextarea(),
        new AdminerEditCalendar(),
        new AdminerForeignSystem,
        new AdminerTablesFilter(),
        new AdminerTinymce,
        new AdminerAutoUpdater(),
    ];

    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */

    return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor
include "./adminer.php";