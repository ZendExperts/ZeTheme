ZeTheme
====
ZeTheme is a Zend Framework 2 module that allows you to switch between various themes.
It allows developers to create various themes for a website and then switch between them at will.

You can define multiple folders where themes are installed and also defined adapters that help in the selection of the current theme.
By default the current theme is displayed based on the configuration file, but the module allows the creation of adapters that can select 
the theme from the session, a database field or any other place you saved it to.

### Installation / Usage

ZeTheme can be installed using Composer by simply adding the following lines to your composer.json file:

    "require": {
        "zendexperts/ze-theme": "dev-master"
    }
    
Then run `php composer.phar update` and add `ZeTheme` in the `application.config.php` file under `modules`.

### Documentation

Within the configuration file for the module you can set the default theme that should be used, the list of directories 
that should be search for various themes and the adapters used for selecting the current theme as listed bellow:

    'ze_theme' => array(
        'default_theme' => 'default',
        'theme_paths' => array(
            __DIR__ . '/../themes/'
        ),
        'adapters' => array(
            'ZeTheme\Adapter\Configuration',
        ),
    ),
    
To get a basic theme up and running you can just copy the `default` one from `examples/theme` folder into the `themes` folder or create a 
new one by following the tutorial bellow. Make sure that the `default_theme` option is set the the name of your new theme.

ZeTheme uses adapters to get the theme that should be rendered. By default the `ZeTheme\Adapter\Configuration` class is used to get the default theme 
specified in the configuration file. There is also a `Session` adapter that retrieves the theme from the `$_SESSION['ZeTheme']` and a `Route` adapter
that allows you to specify a different theme for each route by simply changing the your configuration to somethine similar to this:

    'ze_theme' => array(
        'default_theme' => 'default',
        'theme_paths' => array(
            __DIR__ . '/../themes/'
        ),
        'routes'=>array(
            'back'=>array('home', 'blog')
        ),
        'adapters' => array(
            'ZeTheme\Adapter\Configuration',
            'ZeTheme\Adapter\Route',
        ),
    ),
    
In this case the `back` theme will be used whenever the `home` or `blog` routes are matched. In all other cases the application will use the `default` theme.
     
In order to create a new theme you just need to create a folder with the name of the new theme in one of the directories 
specified by the `theme_paths` array that should contain a `config.php` file that should return a configuration array with 
the paths to the views defined in the new theme.

If you have more complex theme setup you can use dinamic theme path like so:

    'ze_theme' => array(
        'default_theme' => 'default',
        'custom_theme_path' => true,
        'theme_paths' => array(
            __DIR__ . '/../themes/{theme}/frontend/'
        ),
        ...
        
where of course the {theme} will be replaced with the $default_theme

Bellow is an example of such a file:

    <?php
    return array(
        'template_path_stack' => array(
            'default' => __DIR__ . '/view',
        ),
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/view/error/404.phtml',
            'error/index'             => __DIR__ . '/view/error/index.phtml', 
        ),
    );

