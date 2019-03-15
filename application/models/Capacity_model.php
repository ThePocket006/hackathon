<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capacity_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getCapacitiesByCategory(){
        return $this->db->select('cat.name as nCat , cap.*')
            ->distinct('cap.id')
            ->from('ci_category cat')
            ->join('ci_capacity cap','cat.id = cap.categorie')
            ->group_by('cap.categorie')
            ->order_by('cat.name','ASC')
            ->get()
            ->result();
    }
    public function getCapacitiesRole($role)
    {
        return $this->db->select('*')->from('ci_capacity_role cR')
            ->join('ci_capacity c', 'cR.capacite = c.id')
            ->where('cR.role', $role)
            ->get()
            ->result();
    }
    public function getCapacityByCatOfRole($category ,$role){
        return $this->db->select('*')->from('ci_capacity_role capRole')
            ->join('ci_capacity cap','capRole.capacite = cap.id')
            ->where('cap.category',$category)
            ->where('capRole.role',$role)
            ->order_by('cap.ordre','ASC')
            ->get()
            ->result();
    }


}