<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class U_Model extends CI_Model
{
    protected $table_prefix = '';
    protected $config_database;
    protected $table_capacity = 'capacity';
    protected $table_capacity_group = 'capacity_group';
    protected $table_capacity_link = 'capacity_link';
    protected $table_capacity_user = 'capacity_user';
    protected $table_groupmeta = 'groupmeta';
    protected $table_group = 'group';
    protected $table_link = 'link';
    protected $table_user = 'user';
    protected $table_usermeta = 'usermeta';
    protected $table_user_group = 'user_group';
    protected $table_options = 'options';

    function __construct()
    {
        parent::__construct();

        $this->config->load('user_database', true);
        if($this->config->item('table_prefix', 'user_database'))
            $this->table_prefix = $this->config->item('table_prefix', 'user_database');
        $this->config_database = $this->config->item('database', 'user_database');
    }

    protected function vardump(...$expression)
    {
        echo "<pre>";
        foreach ($expression as $item) {
            var_dump($item);
        }
        echo "</pre>";
        die();
    }

    protected function _hash_pass($pass)
    {
        return sha1($pass);
    }

    protected function _verify_required_field(array $data, $table)
    {
        foreach($this->config_database['table_'.$table] as $key => $item){
            $test = true;
            foreach($item as $k => $value){
                if(strcasecmp($k, 'default') == 0 Or strcasecmp($k, 'null') == 0 Or strcasecmp($k, 'auto_increment') == 0){
                    $test = false;
                    break;
                }
            }
            if($test === false And !array_key_exists($key, $data)){
                log_message('error', "Missing key '$key' in the table");
                return false;
            }
        }
        return true;
    }
}