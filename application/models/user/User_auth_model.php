<?php
defined('BASEPATH') Or exit('No direct script access allowed');
 
class User_auth_model extends U_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function auth($login, $pass)
    {
        return $this->db->select('us.id , us.pwd, us.name as userName , us.photo as photo , us.email as email, us.groupe , us.s_groupe ,us.role , us.login ,r.nom as roleName ,
                                 grp.name as grpName , sgrp.nom as sgrpName')
            ->from('ci_user us')
            ->join('ci_group grp','us.groupe = grp.id')
            ->join('ci_sous_groupe sgrp','us.s_groupe = sgrp.id','left')
            ->join('role r','us.role = r.id')
            ->where(['us.login' => $login, 'us.pwd' => $this->_hash_pass($pass),'us.status'=>COMPTE_ACTIF])
            ->get()
            ->result();
    }

    public function updateLastConnection($user)
    {
        if(is_numeric($user)){
            return $this->db->set('last_connection', moment()->format(NO_TZ_MYSQL))
                ->where('id', $user)->update($this->table_prefix.$this->table_user);
        }
        return false;
    } 
}