<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 24.11.14                                      
  * ----------------------------------------------------
  *
  */


namespace RznBase\EventManager;
use Zend\EventManager\EventManager as ZendEventManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\PriorityQueue;
use Zend\Stdlib\CallbackHandler;

class EventManager extends ZendEventManager implements ServiceLocatorAwareInterface
{
    protected $serviceManager;

    protected $eventConfig = [];

    /**
     *
     * @param $config
     * @return $this
     */
    public function setEventConfig($config)
    {
        $this->setEventClass('RznBase\EventManager\Event');
        if ($config) {
            $this->eventConfig = $config;
        }
        return $this;
    }

    /**
     * Этот метод перенружает оригинальный и объявляет обработчики событий перед непосредственным их вызовом.
     *
     * @param string $event
     * @param null $target
     * @param array $argv
     * @param null $callback
     * @return \Zend\EventManager\ResponseCollection
     */
    public function trigger($event, $target = null, $argv = array(), $callback = null)
    {
        // Зарегистрировать обратотчики событий.
        if (is_string($event) and isset($this->eventConfig[$event])) {
            if (isset($this->eventConfig[$event]['invokables']) and is_array($this->eventConfig[$event]['invokables'])) {
                foreach($this->eventConfig[$event]['invokables'] as $listener) {
                    $object = new $listener();
                    if ($object instanceof ServiceLocatorAwareInterface) {
                        $object->setServiceLocator($this->serviceManager);
                    }
                    $this->attach($event, $object);
                }
            }

            if (isset($this->eventConfig[$event]['factories']) and is_array($this->eventConfig[$event]['factories'])) {
                foreach($this->eventConfig[$event]['factories'] as $listener) {
                    $object = new $listener();
                    $object = $object->createEventListener($this->serviceManager);
                    $this->attach($event, $object);
                }
            }

            if (isset($this->eventConfig[$event]['services']) and is_array($this->eventConfig[$event]['services'])) {
                foreach($this->eventConfig[$event]['services'] as $listener) {
                    $object = $this->serviceManager->get($listener);
                    $this->attach($event, $object);
                }
            }
            // Уже зарегистрированные обработчики удаляем.
            unset($this->eventConfig[$event]);
        }
        // Отбработать события
        return parent::trigger($event, $target, $argv, $callback);
    }

    public function attach($event, $object = null, $priority = 1)
    {
        // If we don't have a priority queue for the event yet, create one
        if (empty($this->events[$event])) {
            $this->events[$event] = new PriorityQueue();
        }

        /**
         * Если не неализован метод __invoke смотрим есть ли нужный интефейс.
         * Упаковываем в замыкание для того, чтобы скормить битриксу.
         */
        if (!is_callable($object)) {
            if ($object instanceof EventListenerInterface) {
                $object = function($e) use ($object) {
                    return $object->trigger($e);
                };
            }
        }
        // Create a callback handler, setting the event and priority in its metadata
        $listener = new CallbackHandler($object, array('event' => $event, 'priority' => $priority));

        // Inject the callback handler into the queue
        $this->events[$event]->insert($listener, $priority);
        return $listener;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        if (isset($config['rzn_event_manager'])) {
            $this->setEventConfig($config['rzn_event_manager']);
        }
        $this->serviceManager = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceManager;
    }


}