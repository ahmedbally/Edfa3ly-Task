<?php


namespace App\Models;

abstract class Model {
    protected $fillable =[];
    protected $attributes = [];
    protected $primaryKey = 'id';

    public function __construct($attributes) {
        $this->fill($attributes);
    }

    public function __get($key) {
        if (! $key) {
            return null;
        }
        if (array_key_exists($key, $this->attributes)){
            return $this->attributes[$key] ?? null;
        }
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }
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

    public function getKeyName(){
        return $this->primaryKey;
    }

    public function getKey(){
        return $this->attributes[$this->primaryKey];
    }

    public function toArray(){
        return $this->attributes;
    }
}
