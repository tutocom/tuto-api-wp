<?php

namespace Tuto\Object\Contributor;

class Statistics
{
    /**
     *
     * @var \Tuto\Client
     */
    private $master;
    
    /**
     *
     * @var string 
     */
    private $endpoint = 'contributor/statistics';
    
    /**
     * 
     * @param \Tuto\Client $master
     */
    public function __construct(\Tuto\Client $master)
    {
        $this->master = $master;
    }
    
    /**
     *
     * @return mixed
     */
    public function common()
    {
        $_params = array();
        return $this->master->call('get',$this->endpoint.'/common',$_params);
    }
    
    /**
     *
     * @return mixed
     */
    public function rating()
    {
        $_params = array();
        return $this->master->call('get',$this->endpoint.'/rating',$_params);
    }
    
    /**
     *
     * @return mixed
     */
    public function tutorials()
    {
        $_params = array();
        return $this->master->call('get',$this->endpoint.'/tutorials',$_params);
    }
    
    /**
     *
     * @return mixed
     */
    public function sales()
    {
        $_params = array();
        return $this->master->call('get',$this->endpoint.'/sales',$_params);
    }
    
    /**
     *
     * @return mixed
     */
    public function customers()
    {
        $_params = array();
        return $this->master->call('get',$this->endpoint.'/customers',$_params);
    }

}
