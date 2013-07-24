<?php
/**
 * This file is part of ZeTheme
 *
 * (c) 2013 ZendExperts <team@zendexperts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZeTheme;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

/**
 * ZeTheme module class
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Module
{

    public function onBootstrap(MvcEvent $event)
    {
        // Set the static service manager instance so we can use it everywhere in the module
        $serviceManager = $event->getApplication()->getServiceManager();
        $themeManager = $serviceManager->get('ZeThemeManager');
        $themeManager->init();
    }

    /**
     * Get core configuration array
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Get Autoloader Config
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * Get Service Configuration
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ZeThemeManager' => 'ZeTheme\Service\ManagerFactory'
            )
        );
    }
}