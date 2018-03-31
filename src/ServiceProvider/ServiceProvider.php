<?php
/*
 * Copyright(c) 2018 Daisy Inc. All Rights Reserved.
 *
 * This software is released under the MIT license.
 * http://opensource.org/licenses/mit-license.php
 */

namespace Plugin\NemPaymentExtension\ServiceProvider;

use Plugin\NemPaymentExtension\Nem\Exchange\XemJpyZaifExchanger;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
        try {
            $app['plugin.nem.exchangers'] = Application::share($app->extend('plugin.nem.exchangers', function ($exchangers) {
                $exchangers[] = new XemJpyZaifExchanger();
                return $exchangers;
            }));
        } catch (\InvalidArgumentException $e) {
        }
    }
}
