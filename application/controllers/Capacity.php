<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capacity extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->zone = 'capacity';
        $this->load->model('user/U_Model');
        $this->load->model('Capacity_model', 'mCap');
        $this->load->model('User_model', 'mUs');
        $this->load->library('form_validation');
    }
    public function  saveCapacity(){
        $this->data['categories'] = $this->mSet->selectTableCriterion('*','ci_category', 'id != 0','name','ASC');
        if(isset($_POST['save'])){
            $data = array(
                'name'=>$_POST['Ncap'],
                'link'=>$_POST['Lcap'],
                'creation_date'=>moment()->format('Y-m-d'),
                'description'=>$_POST['Dcap'],
                'icone'=>$_POST['Icap'],
                'category'=>$_POST['Ccap'],
                'ordre'=>$_POST['ordre']
            );
            $cap = $this->mSet->saveTable($data,'ci_capacity');
            redirect('Capacity/capacityList');
        }

        $this->render('save_capacity', translate('Sauvegarder une capacité', 'Save a capacity'));
    }
    public function capacityList(){
        $this->data['capacities'] = $this->mSet->selectTableCriterion('*','ci_capacity', 'id!=0','name','ASC');
        $this->render('capacity_list', translate('Liste des capacité', 'Capacity List'));
    }
    public function editCapacity($capacity){
        $this->data['categories'] = $this->mSet->selectTableCriterion('*','ci_category', 'id != 0','name','ASC');
        $this->data['capacity'] = $this->mSet->selectTableCriterion('*','ci_capacity', 'id ='.$capacity,'name','ASC')[0];
        if(isset($_POST['save'])){
            $data = array(
                'name'=>$_POST['Ncap'],
                'link'=>$_POST['Lcap'],
                'description'=>$_POST['Dcap'],
                'icone'=>$_POST['Icap'],
                'category'=>$_POST['Ccap'],
                'ordre'=>$_POST['ordre']
            );
            $this->mSet->updateTableCriterion($data,'ci_capacity',array('id'=>$capacity));
            redirect('Capacity/capacityList');
        }

        $this->render('edit_capacity', translate('Sauvegarder une capacité', 'Save a capacity'));
    }
    public function  saveCategory(){
        if(isset($_POST['save'])){
            $data = array(
                'name'=>$_POST['Ncap'],
                'icone'=>$_POST['Icap'],
                'ordre'=>$_POST['ordre']

            );
            $cap = $this->mSet->saveTable($data,'ci_category');
            redirect('Capacity/categoryList');
        }

        $this->render('save_category', translate('Sauvegarder une catégorie', 'Save a capacity'));
    }
    public function categoryList(){
        $this->data['categories'] = $this->mSet->selectTableCriterion('*','ci_category', 'id!=0','name','ASC');
        $this->render('category_list', translate('Liste des capacité', 'Capacity List'));
    }
    public function editCategory($category){
        $this->data['category'] = $this->mSet->selectTableCriterion('*','ci_category', 'id ='.$category,'name','ASC')[0];
        if(isset($_POST['save'])){
            $data = array(
                'name'=>$_POST['Ncap'],
                'icone'=>$_POST['Icap'],
                'ordre'=>$_POST['ordre']
            );
            $this->mSet->updateTableCriterion($data,'ci_category',array('id'=>$category));
            redirect('Capacity/categoryList');
        }

        $this->render('edit_category', translate('Sauvegarder une catégorie', 'Save a category'));
    }
}