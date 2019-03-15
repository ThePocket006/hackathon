<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User
{
    protected $CI;

    function __construct()
    {
        $this->CI =& get_instance();
    }
}