<?php
/**
 * This file is part of ZeTheme
 *
 * (c) 2012 ZendExperts <team@zendexperts.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZeTheme\Adapter;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Theme selector abstract adapter
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
abstract class AbstractAdapter implements AdapterInterface
{
    protected $serviceLocator;
    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Persist the name of the theme in the adapter if possible
     * @param string $theme
     * @return bool
     */
    public function setTheme($theme)
    {
        return false;
    }

}