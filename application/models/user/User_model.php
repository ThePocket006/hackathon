<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_model extends U_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function addUser($name, $login='', $pass='', $status=0)
    {
        if(is_array($name)){
            if($this->_verify_required_field($name, $this->table_user)){
                if(!array_key_exists('register_date', $name)){
                    $name['register_date'] = moment()->format(NO_TZ_MYSQL);
                }
            }else{
                return false;
            }
        }else{
            $name = [
                'name' => $name,
                'login' => $login,
                'pwd' => $this->_hash_pass($pass),
                'status' => $status,
                'register_date' => moment()->format(NO_TZ_MYSQL)
            ];
        }
        if($this->db->set($name)->insert($this->table_prefix.$this->table_user)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function addMetaUser($user, $meta_key, $meta_value = '')
    {
        if(count($tmp = $this->getUser($user)) == 1){
            $user = $tmp[0]->id;
            $data_insert = [];
            $data_update = [];

            if(is_array($meta_key))
            {
                foreach($meta_key as $key => $value){
                    if($this->getMetaUser($user, $key)){
                        $data_update[] = ['meta_key' => $key, 'meta_value' => $value];
                    }else{
                        $data_insert[] = ['id_user' => $user, 'meta_key' => $key, 'meta_value' => $value];
                    }
                }
            }else{
                if($this->getMetaUser($user, $meta_key)){
                    $data_update[] = ['meta_key' => $meta_key, 'meta_value' => $meta_value];
                }else{
                    $data_insert[] = ['id_user' => $user, 'meta_key' => $meta_key, 'meta_value' => $meta_value];
                }
            }
            $return = true;
            if($data_insert And $this->db->insert_batch($this->table_prefix.$this->table_usermeta, $data_insert) === false)
                $return = false;
            if($return And $data_update And $this->db->where('id_user', $user)->update_batch($this->table_prefix.$this->table_usermeta, $data_update, 'meta_key') === false)
                $return = false;
            return $return;
        }else{
            log_message('error', get_called_class().": The '$user' user does not exist");
            return false;
        }
    }

    public function getMetaUser($user, $meta_key = '')
    {
        if(is_numeric($user)){
            $this->db->where('id_user', $user);
        }
        if(is_string($meta_key) And $meta_key){
            $this->db->where('meta_key', $meta_key);
        }
        return $this->db->get($this->table_prefix.$this->table_usermeta)->result();
    }

    public function getUser($key = '')
    {
        if(is_numeric($key)){
            $this->db->where('id', $key);
        }
        return $this->db->get($this->table_prefix.$this->table_user)->result();
    }

    public function addGroup($name, $description = '', $status = 0)
    {
        if(is_array($name)){
            if($this->_verify_required_field($name, $this->table_group)){
                if(!array_key_exists('creation_date', $name)){
                    $name['creation_date'] = moment()->format(NO_TZ_MYSQL);
                }
            }else{
                return false;
            }
        }else{
            $name = [
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'creation_date' => moment()->format(NO_TZ_MYSQL)
            ];
        }
        if($this->db->set($name)->insert($this->table_prefix.$this->table_group)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function addMetaGroup($group, $meta_key, $meta_value = '')
    {
        if(count($tmp = $this->getGroup($group)) == 1){
            $group = $tmp[0]->id;
            $data_insert = [];
            $data_update = [];

            if(is_array($meta_key))
            {
                foreach($meta_key as $key => $value){
                    if($this->getMetaGroup($group, $key)){
                        $data_update[] = ['meta_key' => $key, 'meta_value' => $value];
                    }else{
                        $data_insert[] = ['id_group' => $group, 'meta_key' => $key, 'meta_value' => $value];
                    }
                }
            }else{
                if($this->getMetaGroup($group, $meta_key)){
                    $data_update[] = ['meta_key' => $meta_key, 'meta_value' => $meta_value];
                }else{
                    $data_insert[] = ['id_group' => $group, 'meta_key' => $meta_key, 'meta_value' => $meta_value];
                }
            }
            $return = true;
            if($data_insert And $this->db->insert_batch($this->table_prefix.$this->table_groupmeta, $data_insert) === false)
                $return = false;
            if($return And $data_update And $this->db->where('id_group', $group)->update_batch($this->table_prefix.$this->table_groupmeta, $data_update, 'meta_key') === false)
                $return = false;
            return $return;
        }else{
            log_message('error', get_called_class().": The '$group' group does not exist");
            return false;
        }
    }

    public function getMetaGroup($group, $meta_key = '')
    {
        if(is_numeric($group)){
            $this->db->where('id_group', $group);
        }
        if(is_string($meta_key) And $meta_key){
            $this->db->where('meta_key', $meta_key);
        }
        return $this->db->get($this->table_prefix.$this->table_groupmeta)->result();
    }

    public function getGroup($key = '')
    {
        if(is_numeric($key)){
            $this->db->where('id', $key);
        }elseif(is_string($key) And $key){
            $this->db->where('name', $key);
        }
        return $this->db->get($this->table_prefix.$this->table_group)->result();
    }

    public function addCapacityUser($user, $capacity)
    {
        if(count($userTMP = $this->getUser($user)) == 1 And count($capacityTMP = $this->getCapacity($capacity)) == 1){
            $user = $userTMP[0]->id;
            $capacity = $capacityTMP[0]->id;
            if(!$this->getCapacityUser($user, $capacity)){
                $data = ['id_user' => $user, 'id_capacity' => $capacity];
                return $this->db->set($data)->insert($this->table_prefix.$this->table_capacity_user);
            }
            return true;
        }
        log_message('error', get_called_class().": The user '$user' and/or the capacity '$capacity' does not exist.");
        return false;
    }

    public function addCapacityGroup($group, $capacity)
    {
        if(count($groupTMP = $this->getGroup($group)) == 1 And count($capacityTMP = $this->getCapacity($capacity)) == 1){
            $group = $groupTMP[0]->id;
            $capacity = $capacityTMP[0]->id;
            if(!$this->getCapacityGroup($group, $capacity)){
                $data = ['id_group' => $group, 'id_capacity' => $capacity];
                return $this->db->set($data)->insert($this->table_prefix.$this->table_capacity_group);
            }
            return true;
        }
        log_message('error', get_called_class().": The group '$group' and/or the capacity '$capacity' does not exist.");
        return false;
    }

    public function addCapacity($name, $description = '', $status = 0)
    {
        if(is_array($name)){
            if($this->_verify_required_field($name, $this->table_capacity)){
                if(!array_key_exists('creation_date', $name)){
                    $name['creation_date'] = moment()->format(NO_TZ_MYSQL);
                }
            }else{
                return false;
            }
        }else{
            $name = [
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'creation_date' => moment()->format(NO_TZ_MYSQL)
            ];
        }
        if($this->db->set($name)->insert($this->table_prefix.$this->table_capacity)){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }

    public function getCapacity($key = '')
    {
        if(is_numeric($key)){
            $this->db->where('id', $key);
        }elseif(is_string($key) And $key){
            $this->db->where('name', $key);
        }
        return $this->db->get($this->table_prefix.$this->table_capacity)->result();
    }

    public function getCapacityUser($user, $capacity = '')
    {
        if(is_numeric($user)){
            $this->db->where('ci_cpu.id_user', $user);
        }
        if(is_numeric($capacity)){
            $this->db->where('ci_cpu.id_capacity', $capacity);
        }
        $this->db->from($this->table_prefix.$this->table_capacity.' ci_cp')
            ->join($this->table_prefix.$this->table_capacity_user.' ci_cpu', 'ci_cp.id = ci_cpu.id_'.$this->table_capacity);
        return $this->db->get()->result();
    }

    public function getCapacityGroup($group, $capacity = '')
    {
        if(is_numeric($group)){
            $this->db->where('ci_cpg.id_group', $group);
        }
        if(is_numeric($capacity)){
            $this->db->where('ci_cpg.id_capacity', $capacity);
        }
        $this->db->from($this->table_prefix.$this->table_capacity.' ci_cp')
            ->join($this->table_prefix.$this->table_capacity_group.' ci_cpg', 'ci_cp.id = ci_cpg.id_'.$this->table_capacity);
        return $this->db->get()->result();
    }
}