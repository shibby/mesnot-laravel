<?php

namespace Shibby\Mesnot;

class MesnotMessage
{
    /**
     * @var string
     */
    private $eventKey;

    /**
     * @var array|null
     */
    private $parameters;

    /**
     * @return string
     */
    public function getEventKey(): string
    {
        return $this->eventKey;
    }

    /**
     * @param string $eventKey
     *
     * @return MesnotMessage
     */
    public function setEventKey($eventKey): MesnotMessage
    {
        $this->eventKey = $eventKey;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array|null $parameters
     *
     * @return MesnotMessage
     */
    public function setParameters($parameters): MesnotMessage
    {
        $this->parameters = $parameters;

        return $this;
    }
}
