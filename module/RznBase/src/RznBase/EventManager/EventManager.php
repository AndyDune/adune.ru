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
        if ($config and !is_array($config)) {
            //$this->eventConfig = $config->toArray(); // todo рассмотреть необходимсто этого
            $this->eventConfig = $config;
        }
        return $this;
    }

    public function trigger($event, $target = null, $argv = array(), $callback = null)
    {
        // Зарегистрировать обратотчики событий.
        if (is_string($event) and isset($this->eventConfig[$event])) {
            if (isset($this->eventConfig[$event]['invokables']) and is_array($this->eventConfig[$event]['invokables'])) {
                foreach($this->eventConfig[$event]['invokables'] as $listener) {
                    $this->attachInvokable($event, $listener);
                }
            }

            if (isset($this->eventConfig[$event]['factories']) and is_array($this->eventConfig[$event]['factories'])) {
                foreach($this->eventConfig[$event]['factories'] as $listener) {
                    $this->attachFactory($event, $listener);
                }
            }

            if (isset($this->eventConfig[$event]['services']) and is_array($this->eventConfig[$event]['services'])) {
                foreach($this->eventConfig[$event]['services'] as $listener) {
                    $this->attachService($event, $listener);
                }
            }
            unset($this->eventConfig[$event]);
        }
        // Отбработать события
        return parent::trigger($event, $target, $argv, $callback);
    }

    public function attachInvokable($event, $class, $priority = 1)
    {
        // If we don't have a priority queue for the event yet, create one
        if (empty($this->events[$event])) {
            $this->events[$event] = new PriorityQueue();
        }

        $object = new $class();
        if ($object instanceof ServiceLocatorAwareInterface) {
            $object->setServiceLocator($this->serviceManager);
        }
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

    public function attachFactory($event, $class, $priority = 1)
    {
        // If we don't have a priority queue for the event yet, create one
        if (empty($this->events[$event])) {
            $this->events[$event] = new PriorityQueue();
        }

        $object = new $class();
        $object = $object->createEventListener($this->serviceManager);
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

    public function attachService($event, $service, $priority = 1)
    {
        // If we don't have a priority queue for the event yet, create one
        if (empty($this->events[$event])) {
            $this->events[$event] = new PriorityQueue();
        }

        $object = $this->serviceManager->get($service);
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