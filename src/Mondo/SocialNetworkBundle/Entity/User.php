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

    public function getGender() {
        $map = [
            'm' => 'male',
            'f' => 'female',
            'n' => 'other'
        ];
        return $map[$this->data['gender']];
    }

    public function getOrientation() {
        $map = [
            'hetero' => 'heterosexual',
            'homo' => 'homosexual',
            'bi' => 'bisexual',
            'a' => 'asexual'
        ];
        return $map[$this->data['orientation']];
    }

    public function get($key) {
        if(method_exists($this, 'get'.$key)) return call_user_func([$this, 'get'.$key]); 
        return $this->data[$key];
    }

    private function getAge() {
        if(!is_null($this->data['birth'])) return (new \DateTime())->diff(new \DateTime($this->data['birth']))->y;
        else return "";
    }
}
