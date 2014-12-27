<?php

namespace Tuto\Object;

class Contributor
{
    /**
     *
     * @var \Tuto\Object\Contributor\Statistics
     */
    public $statistics;
    
    public function __construct(\Tuto\Client $master)
    {
        $this->statistics = new Contributor\Statistics($master);
    }
    
    /**
     * 
     * @param string type of stats
     * @return mixed
     */
    public function statistics($type = '')
    {
        if(isset($type) && !empty($type))
        {
            if(method_exists($this->statistics, $type))
            {
                return $this->statistics->$type();
            }
        }
        else
        {
            return $this->statistics->common();
        }
    }

}