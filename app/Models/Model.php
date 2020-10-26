<?php


namespace App\Models;

use App\Traits\HasAttributes;

abstract class Model {
    use HasAttributes;
    protected $fillable =[];
    protected $attributes = [];
    protected $primaryKey = 'id';

    /**
     * Model constructor.
     * @param array $attributes
     */
    public function __construct($attributes=[]) {
        $this->fill($attributes);
    }

    /**
     * magic function to get attribute value
     * @param $key
     * @return mixed|void|null
     */
    public function __get($key) {
        return $this->getAttribute($key);
    }

    /**
     * magic function to set attribute value
     * @param $key
     * @param $value mixed
     */
    public function __set($key, $value) {
        $this->setAttribute($key,$value);
    }

    /**
     * fill all attributes by array
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes){
        if (count($this->fillable) > 0) {
            $attributes= array_intersect_key($attributes, array_flip($this->fillable));
        }
        foreach ($attributes as $key=>$value){
            if(in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * get primary key name
     * @return string
     */
    public function getKeyName(){
        return $this->primaryKey;
    }

    /**
     * get primary key value
     * @return mixed
     */
    public function getKey(){
        return $this->attributes[$this->primaryKey];
    }

    /**
     * convert class to array
     * @return array
     */
    public function toArray(){
        return $this->attributes;
    }
}
