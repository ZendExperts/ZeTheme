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
 * Theme selector adapter interface
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
interface AdapterInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator);

    /**
     * Get the name of the theme from the adapter
     * @abstract
     * @return string | null
     */
    public function getTheme();

    /**
     * Persist the name of the theme in the adapter if possible
     * @abstract
     * @param string $theme
     * @return bool
     */
    public function setTheme($theme);
}