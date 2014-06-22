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
 * @package     RznPress
 * @author      Andrey Ryzhov <info@rznw.ru>
 * @copyright   2014 Andrey Ryzhov.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link https://github.com/AndyDune/RznPress for the canonical source repository
 */


namespace RznPress\Router;

use Zend\Mvc\Router\Http\RouteInterface;
use Zend\Mvc\Router\Http\RouteMatch;
use Traversable;
use Zend\Mvc\Router\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;


class PathArrayParams implements RouteInterface
{

    /**
     * List of assembled parameters.
     *
     * @var array
     */
    protected $assembledParams = array();


    protected $route    = '';

    protected $defaults = [];

    /**
     * Ключевые сегменты в запросе, которые перобразуются в параметры.
     * Каждый параметр может быть массивом с указанными в $constraints требованиями.
     *
     * @var array
     */
    protected $params = [];


    /**
     * Возможные значения:
     * require - обязательный параметр
     * count_min - минимальный размер массива значений параметра. После встречи параметра.
     * count_max - максимальный рамер массива.
     * last_to_string - игнорирование всех параметров кроме последнего, который возвращается как строка.
     * regex - регулярное выражение todo сделать проверку
     *
     * Если на входе строка, то считается, что это параметр regex
     *
     *
     * @var array
     */
    protected $constraints = [];

    /**
     *
     * @param  string $route
     * @param  array  $defaults
     */
    public function __construct($route, array $params = [], array $constraints = [], array $defaults = [])
    {
        $this->route    = rtrim($route, '/');
        $this->defaults = $defaults;
        $this->params = $params;
        $this->constraints = $constraints;
    }


    /**
     * factory(): defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::factory()
     * @param  array|Traversable $options
     * @return ArticleList
     * @throws Exception\InvalidArgumentException
     */
    public static function factory($options = [])
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (!isset($options['route'])) {
            throw new Exception\InvalidArgumentException('Missing "route" in options array');
        }

        if (!isset($options['defaults'])) {
            $options['defaults'] = [];
        }

        if (!isset($options['constraints'])) {
            $options['constraints'] = [];
        }

        if (!isset($options['params'])) {
            $options['params'] = [];
        }


        return new static($options['route'], $options['params'], $options['constraints'], $options['defaults']);
    }

    /**
     * match(): defined by RouteInterface interface.
     *
     * @see    \Zend\Mvc\Router\RouteInterface::match()
     * @param  Request      $request
     * @param  integer|null $pathOffset
     * @return RouteMatch|null
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        $uri  = $request->getUri();
        $path = $uri->getPath();

        $position = strpos($path, $this->route);
        if ($position !== 0) {
            return null;
        }


        //echo $this->route;
        $matchedString = substr($path, strlen($this->route));

        $matchedLength = strlen($matchedString);

        $firstSymbol = substr($matchedString, 0, 1);
        if ($firstSymbol and $firstSymbol != '/') {
            return null;
        }

        echo $matchedString;

        $params = array();

        $parts = explode('/', $matchedString);

        foreach($parts as $part) {
            if (!$part) continue;

        }


        return new RouteMatch(array_merge($this->defaults, $params), $matchedLength);


        return null;
    }

    public function assemble(array $params = array(), array $options = array())
    {

    }

    /**
     * getAssembledParams(): defined by RouteInterface interface.
     *
     * @see    RouteInterface::getAssembledParams
     * @return array
     */
    public function getAssembledParams()
    {
        return $this->assembledParams;
    }
} 