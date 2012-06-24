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

/**
 * ZeTheme adapter that returns the name of the theme specified in the configuration file
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Configuration extends AbstractAdapter
{

    public function getTheme()
    {
        $config = $this->serviceLocator->get('Configuration');
        if (!isset($config['ze_theme']['default_theme'])){
            return null;
        }
        return $config['ze_theme']['default_theme'];
    }

}