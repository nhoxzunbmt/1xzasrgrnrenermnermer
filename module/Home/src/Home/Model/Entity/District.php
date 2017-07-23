<?php

namespace Home\Model\Entity;

class District
{
    public $id;
    public $city_id;
    public $name;
    public $is_active;
    public $alias;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? intval($data['id']) : null;
        $this->city_id = (!empty($data['city_id'])) ? $data['city_id'] : 0;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : 0;
        $this->alias = (!empty($data['alias'])) ? $data['alias'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }

}