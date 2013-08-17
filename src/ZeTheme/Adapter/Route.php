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
 * ZeTheme adapter that returns the name of the theme specified in the configuration file based on the matched route
 * @package ZeTheme
 * @author Cosmin Harangus <cosmin@zendexperts.com>
 */
class Route extends AbstractAdapter
{

	public function getTheme()
	{

		$config = $this->serviceLocator->get('Configuration');
		$app = $this->serviceLocator->get('Application');
		$request = $app->getRequest();
		$router = $this->serviceLocator->get('Router');

		if (!$router->match($request)) return null;

		if (!isset($config['ze_theme']['routes']) || !is_array($config['ze_theme']['routes'])){
			return null;
		}

		$matchedRoute = $router->match($request)->getMatchedRouteName();

		if($config['ze_theme']['split_theme'] === true){

			list($topRoute, $childRoutes) = explode('/', $matchedRoute, 2);
			foreach($config['ze_theme']['routes'] as $theme => $pair){
				foreach($pair as $subTheme => $routes){
					if (!is_array($routes)) $routes = array($routes);
					foreach($routes as $route){
						if ($route == $topRoute){
							$this->setSubTheme($subTheme);
							return $theme;
						}
					}
				}
			}

		}
		else{

			foreach($config['ze_theme']['routes'] as $key => $routes){
				if (in_array($matchedRoute, $routes)) return $key;
			}

		}

		return null;

	}

}