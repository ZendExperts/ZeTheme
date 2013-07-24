<?php

/**
 * This file is part of ZeTheme
 *
 * (c) 2012 ZendExperts <team@zendexperts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZeTheme;
use Zend\Stdlib\PriorityQueue,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * ZeTheme manager
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Manager
{
    /**
     * @var null|\Zend\Stdlib\PriorityQueue
     */
    protected $themePaths = null;
    /**
     * @var null|string
     */
    protected $currentTheme = null;
    /**
     * @var null|\ZeTheme\Adapter\AdapterInterface
     */
    protected $lastMatchedAdapter = null;
    /**
     * @var null|\Zend\Stdlib\PriorityQueue
     */
    protected $adapters = null;
    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceManager;

    public function __construct(ServiceLocatorInterface $serviceManager, $options = array())
    {
        $this->serviceManager = $serviceManager;

        //set the default theme paths (LIFO order)
        $this->themePaths = new PriorityQueue();
        if ( isset($options['theme_paths']) ){
            $priority = 1;
            foreach ($options['theme_paths'] as $path) {
                $this->themePaths->insert($path, $priority++);
            }
        }

        //set up theme selector adapters (LIFO order)
        $this->adapters = new PriorityQueue();
        if ( isset($options['adapters']) ){
            $priority = 1;
            foreach($options['adapters'] as $adapterClass){
                $adapter = new $adapterClass($serviceManager);
                $this->adapters->insert($adapter, $priority++);
            }
        }
    }

    /**
     * Initialize the theme by selecting a theme using the adapters and updating the view resolver
     */
    public function init()
    {
        //if already initialized then return
        if ($this->currentTheme){
            return true;
        }

        //find the current theme that should be used
        $theme = $this->selectCurrentTheme();
        if (!$theme){
            return false;
        }

        //get theme configuration
        $config = $this->getThemeConfig($theme);
        if (!$config){
            return false;
        }

        $viewResolver = $this->serviceManager->get('ViewResolver');
        $themeResolver = new \Zend\View\Resolver\AggregateResolver();
        if (isset($config['template_map'])){
            $viewResolverMap = $this->serviceManager->get('ViewTemplateMapResolver');
            $viewResolverMap->add($config['template_map']);
            $mapResolver = new \Zend\View\Resolver\TemplateMapResolver(
                $config['template_map']
            );
            $themeResolver->attach($mapResolver);
        }

        if (isset($config['template_path_stack'])){
            $viewResolverPathStack = $this->serviceManager->get('ViewTemplatePathStack');
            $viewResolverPathStack->addPaths($config['template_path_stack']);
            $pathResolver = new \Zend\View\Resolver\TemplatePathStack(
                array('script_paths'=>$config['template_path_stack'])
            );
            $defaultPathStack = $this->serviceManager->get('ViewTemplatePathStack');
            $pathResolver->setDefaultSuffix($defaultPathStack->getDefaultSuffix());
            $themeResolver->attach($pathResolver);
        }
        
        $viewResolver->attach($themeResolver, 100);
        return true;
    }

    /**
     * Get the current used theme. If the manager was not initialized or no theme found it will return null.
     * @return string | null
     */
    public function getTheme()
    {
        return $this->currentTheme;
    }

    /**
     * Sets the name of the new theme using the last matched adapter
     * @param string $theme
     * @return bool
     */
    public function setTheme($theme)
    {
        if (!$this->lastMatchedAdapter){
            return false;
        }

        $theme = $this->cleanThemeName($theme);
        return $this->lastMatchedAdapter->setTheme($theme);
    }

    /**
     * Get a theme configuration file
     * @param string $theme
     * @return array | null
     */
    public function getThemeConfig($theme)
    {
        $theme = $this->cleanThemeName($theme);
        $path_iterator = $this->themePaths->getIterator();
        $config = null;
        $n = $path_iterator->count();
        while (!$config && $n-->0) {
        	
            $path = $path_iterator->extract();
            $appConfig = $this->serviceManager->get('Configuration');  
            
            if($appConfig['ze_theme']['custom_theme_path'] === true){
            	$configFile = str_replace('{theme}', $theme, $path) . '/config.php';
			}
            else $configFile = $path . $theme . '/config.php';

            if (file_exists($configFile)){
                $config = include ($configFile);
            }
            
        }

        return $config;
    }

    /**
     * Remove any unwanted characters from a theme name before loading it's config file
     * @param string $theme
     * @return string
     */
    protected function cleanThemeName($theme)
    {
        $theme = str_replace('.', '', $theme);
        $theme = str_replace('/', '', $theme);
        return $theme;
    }

    /**
     * Call each adapter to select a theme until one of theme returns a valid name
     * @return string | null
     */
    protected function selectCurrentTheme()
    {
        $iterator = $this->adapters;
        $theme = null;
        $adapter = null;
        $n = $iterator->count();
        while (!$theme && $n-->0) {
            $adapter = $iterator->extract();
            $theme = $adapter->getTheme();
        }

        if (!$theme) {
            return null;
        }
        $this->lastMatchedAdapter = $adapter;
        $this->currentTheme = $theme;
        return $theme;
    }
}