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
use Zend\Session\SessionManager;

/**
 * ZeTheme adapter that returns the name of the theme specified in the session
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Session extends AbstractAdapter
{

    /**
     * Get the name of the current theme from session if any was set
     * @return null|string
     */
    public function getTheme()
    {
        $session = $this->getSession();
        if (!isset($session->ZeTheme)) {
            return null;
        }
        return $session->ZeTheme;
    }

    /**
     * Save the new theme in session
     * @param string $theme
     * @return bool
     */
    public function setTheme($theme)
    {
        $session = $this->getSession();
        $session->ZeTheme = $theme;
        return true;
    }

    /**
     * return a session storage instance
     * @return \Zend\Session\Storage\StorageInterface
     */
    protected function getSession()
    {
        $sessionManager = new SessionManager();
        $sessionManager->start();
        return $sessionManager->getStorage();
    }

}