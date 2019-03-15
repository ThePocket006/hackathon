<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* id des roles*/
define('ROLE_GENERAL_ADMIN',13);
define('ROLE_CHEF_SERVICE',14);
define('ROLE_SECRETAIRE',15);
define('ROLE_CHEF_DEPARTEMENT',17);
define('ROLE_CHEF_SERVICE_CENTRAL',18);
define('ROLE_CABINET_RECTORAT',19);
define('ROLE_SIMPLE_USER',20);


/*
 * ROLE USER CONNECTE
 */
if(!function_exists('isGeneralAdmin')){
    function isGeneralAdmin(){
        return (session_data('roleId' )== ROLE_GENERAL_ADMIN);
    }
}
if(!function_exists('isChefService')){
    function isChefService(){
        return (session_data('roleId' )== ROLE_CHEF_SERVICE);
    }
}
if(!function_exists('isSecretaire')){
    function isSecretaire(){
        return (session_data('roleId' )== ROLE_SECRETAIRE);
    }
}
if(!function_exists('isChefDepartement')){
    function isChefDepartement(){
        return (session_data('roleId' )== ROLE_CHEF_DEPARTEMENT);
    }
}
if(!function_exists('isChefCentral')){
    function isChefCentral(){
        return (session_data('roleId' )== ROLE_CHEF_SERVICE_CENTRAL);
    }
}
if(!function_exists('isCabinetRectorat')){
    function isCabinetRectorat(){
        return (session_data('roleId' )== ROLE_CABINET_RECTORAT);
    }
}
if(!function_exists('isSimpleUser')){
    function isSimpleUser(){
        return (session_data('roleId' )== ROLE_SIMPLE_USER);
    }
}

/* affichage des menus en fonctions de la personne connectée */
if(!function_exists('renderMenuBtCat'))
{
    function renderMenuByCat($categorie,$role)
    {
        $CI =& get_instance();
        $CI->load->model('Capacity_model', 'mCap');
        return $CI->mCap->getCapacityByCatOfRole($categorie , $role);
    }
}
if(!function_exists('allCategory'))
{
    function allCategory()
    {
        $CI =& get_instance();
        return $CI->mSet->selectTableCriterion('*','ci_category','id!=0','ordre','ASC');
    }
}


