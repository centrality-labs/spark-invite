<?php
namespace ZiNETHQ\SparkInvite;

class SparkInvite
{
    private $instance = null;

    public function invite()
    {
        $invite = new Invite(...);
    }

    /**
     * Fire Laravel event
     * @param  string $event event name
     * @return self
     */
    private function publishEvent($event)
    {
        Event::fire('ZiNETHQ.SparkInvite.'.$event, $this->instance, false);
        return $this;
    }
}
