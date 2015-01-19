<?php
/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/
namespace Mondo\SocialNetworkBundle\Entity;

class User {
    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function get($key) {
        if(array_key_exists($key, $this->data)) return $this->data[$key];
        return call_user_func([$this, 'get'.$key]); 
    }

    private function getAge() {
        if(!is_null($this->data['birth'])) return (new \DateTime())->diff(new \DateTime($this->data['birth']))->y;
        else return "";
    }
}
