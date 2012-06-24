<?php
/**
 * This file is part of ZeTheme
 *
 * (c) 2012 ZendExperts <team@zendexperts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZeTheme\Service;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    ZeTheme\Manager;

/**
 * ZeTheme service manager factory
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class ManagerFactory implements FactoryInterface
{
    /**
     * Factory method for ZeTheme Manager service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return \ZeTheme\Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $manager = new Manager($serviceLocator, $config['ze_theme']);
        return $manager;
    }
}