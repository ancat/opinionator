<?PHP
    require 'includes/Mustache/Autoloader.php';
    Mustache_Autoloader::register();

    $mustache = new Mustache_Engine(
        array('loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../templates'))
    );
?>
