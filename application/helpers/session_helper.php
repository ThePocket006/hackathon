<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined("APPNAME") OR define("APPNAME", "HACKATHON");

/* Etat des comptes */
define('COMPTE_ACTIF',0);
define('COMPTE_BLOQUE',1);

/* Etat des groupes */
define('GROUPE_ACTIF',0);
define('GROUPE_BLOQUE',1);

/* Etat des sous groupes */
define('SGROUPE_ACTIF',0);
define('SGROUPE_BLOQUE',1);

get_instance()->load->library('session');


if(!function_exists('session_data'))
{
    function session_data($key = NULL)
    {
        $CI =& get_instance();
        return $CI->session->userdata($key);
    }
}

if(!function_exists('set_session_data'))
{
    /**
     * Set session data
     *
     * Legacy CI_Session compatibility method
     *
     * @param	mixed	$data	Session data key or an associative array
     * @param	mixed	$value	Value to store
     * @return	void
     */
    function set_session_data($data, $value = NULL)
    {
        $CI =& get_instance();
        $CI->session->set_userdata($data, $value);
    }
}

if(!function_exists('get_session_data'))
{
    function get_session_data($key = '')
    {
        $result = session_data($key);
        unset_session_data($key);
        return $result;
    }
}

if(!function_exists('unset_session_data'))
{
    /**
     * @param string|array|NULL $key
     */
    function unset_session_data($key = NULL)
    {
        $CI =& get_instance();
        if(!$key)
        {
            $CI->session->sess_destroy();
        }
        if(is_string($key))
        {
            $CI->session->unset_userdata($key);
        }
        if(is_array($key))
        {
            foreach($key as $value)
            {
                $CI->session->unset_userdata($value);
            }
        }
    }
}

if(!function_exists('session_data_isset'))
{
    function session_data_isset($key = '')
    {
        $CI =& get_instance();
        $session = $CI->session->userdata();
        if(!$key)
        {
            return isset($session);
        }
        elseif(is_string($key) OR (is_int($key) And $key>=0))
        {
            return isset($session[$key]);
        }
        elseif(is_array($key))
        {
            $result = $key[0];
            if(count($key) != 1)
            {
                array_shift($key);
            }
            else
            {
                $key = $key[0];
            }

            return (session_data_isset($result) And session_data_isset($key));
        }
        return false;
    }
}

if(!function_exists('set_flash_data'))
{
    function set_flash_data($data, $value = NULL)
    {
        $CI =& get_instance();
        $CI->session->set_flashdata($data, $value);
    }
}

if(!function_exists('get_flash_data'))
{
    function get_flash_data($key = NULL)
    {
        if(session_data_isset('flash')) {
            $CI =& get_instance();
            return $CI->session->flashdata($key);
        }
    }
}

if(!session_data_isset('language')) {
    set_session_data(['language' => getLanguage(true)]);
}


if(!function_exists('is_connect'))
{
    function is_connect(){
        $CI =& get_instance();
        return ($CI->session->userdata('id') !== NULL);
    }
}