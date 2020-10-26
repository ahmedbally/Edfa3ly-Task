<?php
namespace App\Traits;


trait HasAttributes
{
    /**
     * @param $key
     * @return mixed|void|null
     */
    public function getAttribute($key){
        if (! $key) {
            return;
        }
        if (array_key_exists($key, $this->attributes)){
            return $this->attributes[$key] ?? null;
        }
    }

    /**
     * @param $key
     * @param $value mixed
     */
    public function setAttribute($key,$value){
        $this->attributes[$key] = $value;
    }

}
