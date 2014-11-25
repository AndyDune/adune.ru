<?php
/**
 * Copyright (c) 2014 Andrey Ryzhov.
 * All rights reserved.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     RznViewFilesPath
 * @author      Andrey Ryzhov <info@rznw.ru>
 * @copyright   2014 Andrey Ryzhov.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link https://github.com/AndyDune/RznViewFilesPath for the canonical source repository
 */
namespace RznViewFilesPath\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Exception;


class ViewFilesPath extends AbstractHelper implements ServiceLocatorAwareInterface
{

    /**
     * Base path for view files.
     *
     * @var string
     */
    protected $path = '';

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    protected $themeDefault = 'default';

    /**
     * Returns site's base path, or file with base path prepended.
     *
     * $file is appended to the base path for simplicity.
     *
     * @param  string|null $file
     * @throws Exception\RuntimeException
     * @return string
     */
    public function __invoke($file = null)
    {
        if (null !== $file) {
            $file = '/' . ltrim($file, '/');
        }

        return $this->getPath() . $file;
    }



    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    protected function getPath()
    {
        if (!$this->path) {
            $services = $this->getServiceLocator()->getServiceLocator();
            $config = $services->get('config');

            if (isset($config['rzn_view_files_path']['view_files_base_path'])) {
                $this->path = '/' . trim($config['rzn_view_files_path']['view_files_base_path'], '/');
            }
            else {
                $this->path = '/';
            }

            if (isset($config['rzn_view_files_path']['view_files_domain'])) {
                $this->path =  $config['rzn_view_files_path']['view_files_domain'] . $this->path;
            }

            $theme = false;
            if (isset($config['rzn_view_files_path']['view_files_theme_service'])) {
                if (is_array($config['rzn_view_files_path']['view_files_theme_service']))
                {
                    foreach($config['rzn_view_files_path']['view_files_theme_service'] as $themeServiceName) {
                        $theme = $services->get($themeServiceName)->getViewFilesTheme();
                        if ($theme)
                            break;
                    }
                }
                else {
                    $theme = $services->get($config['rzn_view_files_path']['view_files_theme_service'])->getViewFilesTheme();
                }
            }

            if ($theme) {
                $this->path .= '/' . $theme;
            }
            else if (isset($config['rzn_view_files_path']['view_files_theme'])) {
                $this->path .= '/' . $config['rzn_view_files_path']['view_files_theme'];
            }
            else {
                $this->path .= '/' . $this->themeDefault;
            }
        }

        return $this->path;
    }

    /**
     * Set the service locator.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CustomHelper
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    /**
     * Get the service locator.
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

} 