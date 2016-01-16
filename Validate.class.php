<?php
/**
 * Created by PhpStorm.
 * User: josec
 * Date: 19/09/2014
 * Time: 16:05
 */


class Validate {

    public $vals;

    function __construct($vals) {

        $this->vals = $vals;

    }

    /**
     * @param $valname
     * @return mixed
     */
    public function basic($valname) {

        if(!isset($this->vals[$valname]) || $this->vals[$valname] == "" || $this->vals[$valname] == null){
            throw new InvalidArgumentException(
                'One or more fields are either empty or invalid.'
            );
        } else {
            return $this->vals[$valname];
        }

    }

    public function greaterThan($minSize, $maxSize ) {

        if($maxSize < $minSize){
            $error = '<h2 style="color: red;">The minimum size is bigger than the maximum size. Change that please!</h2>';
            return $error;
        }
    }




} 