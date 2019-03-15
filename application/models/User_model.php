<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }
    public function  getRoleUsers($role, $group){

        return $this->db->select('*')
            ->from('ci_user')
            ->where('role',$role)
            ->where('groupe',$group)
            ->order_by('name','ASC')
            ->get()
            ->result();

    }
    public function  allUsers($grp = NULL , $sgrp = NULL , $csev = false){
        if($grp == NULL)
            return $this->db->select('u.* , g.name as grpName ,s.nom as sgrpName , r.nom as rName')->from('ci_user u')
            ->join('ci_group g','u.groupe = g.id')
            ->join('ci_sous_groupe s','u.s_groupe = s.id','left')
            ->join('role r','u.role = r.id')
            ->order_by('u.name','ASC')
            ->get()
            ->result();
        elseif($csev == false)
            return $this->db->select('u.* , g.name as grpName ,s.nom as sgrpName , r.nom as rName')->from('ci_user u')
                ->join('ci_group g','u.groupe = g.id')
                ->join('ci_sous_groupe s','u.s_groupe = s.id','left')
                ->join('role r','u.role = r.id')
                ->where('u.groupe',$grp)
                ->where('u.s_groupe',$sgrp)
                ->order_by('u.name','ASC')
                ->get()
                ->result();
        else
            return $this->db->select('u.* , g.name as grpName ,s.nom as sgrpName , r.nom as rName')->from('ci_user u')
                ->join('ci_group g','u.groupe = g.id')
                ->join('ci_sous_groupe s','u.s_groupe = s.id','left')
                ->join('role r','u.role = r.id')
                ->where('u.groupe',$grp)
                ->order_by('u.name','ASC')
                ->get()
                ->result();


    }
}