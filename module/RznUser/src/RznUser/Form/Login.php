<?php
 /**
  * ----------------------------------------------------
  * | Автор: Андрей Рыжов (Dune) <info@rznw.ru>         |
  * | Сайт: www.rznw.ru                                 |
  * | Телефон: +7 (4912) 51-10-23                       |
  * | Дата: 11.11.14                                      
  * ----------------------------------------------------
  *
  */


namespace RznUser\Form;

use Traversable;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class Login extends Form
{

    /**
     * @var EventManagerInterface
     */
    protected $events;

    /**
     * Уставновка менеджера событий.
     *
     * @param  EventManagerInterface $events
     * @return mixed
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * Возврат менеджера событий.
     *
     * Ленивозагрузить менеджер событий, если не был установлен.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (!$this->events instanceof EventManagerInterface) {
            $identifiers = array(__CLASS__, get_called_class());
            if (isset($this->eventIdentifier)) {
                if ((is_string($this->eventIdentifier))
                    || (is_array($this->eventIdentifier))
                    || ($this->eventIdentifier instanceof Traversable)
                ) {
                    $identifiers = array_unique($identifiers + (array) $this->eventIdentifier);
                } elseif (is_object($this->eventIdentifier)) {
                    $identifiers[] = $this->eventIdentifier;
                }
                // silently ignore invalid eventIdentifier types
            }
            $this->setEventManager(new EventManager($identifiers));
        }
        return $this->events;
    }
}
