<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
 
class Log_model extends MY_Model
{
    private $config_file = 'un_log';

    function __construct()
    {
        parent::__construct();
    }

    public function add($code, $message)
    {
        $this->load->library('user_agent');
        $this->config->load($this->config_file, true);

        $codeTMP = mb_strtoupper($code);

        if(strcasecmp($codeTMP, 'API') == 0) $code = 'DEBUG';
        if(in_array($code, explode('|', 'ERROR|DEBUG|INFO'))){
            log_message($code, $message);
        }
        $code = $codeTMP;

        $valid_log = [];
        if(is_array($this->config->item('log_code_block', $this->config_file))){
            foreach($this->config->item('log_code_block', $this->config_file) as $item){
                $valid_log[] = mb_strtoupper($item);
            }
        }elseif(is_string($this->config->item('log_code_block', $this->config_file))){
            $valid_log = mb_strtoupper($this->config->item('log_code_block', $this->config_file));
        }

        $valid_log = ($valid_log?(array)$valid_log:[]);
        if(!$valid_log Or in_array('ALL', $valid_log) Or !in_array($code, $valid_log)){
            if(is_connect()){
                $user = $this->session->userdata('id');
            }else{
                $user = 0;
            }

            $data = [];
            $data['date'] = moment()->format(NO_TZ_MYSQL);
            $data['code'] = $code;
            $data['user'] = $user;
            $data['message'] = $message;
            $data['address'] = $this->input->ip_address();
            $data['agent'] = $this->agent->agent;

            $this->db->set($data)->insert($this->table_log);
        }
    }

    public function get($user = '', $where = [])
    {
        $this->config->load('user_database', true);
        if($this->config->item('table_prefix', 'user_database'))
            $this->table_prefix = $this->config->item('table_prefix', 'user_database');

        $this->_reset()
            ->select()
            ->from($this->table_log.' lg')
            ->join($this->table_prefix . $this->table_user.' u', 'u.id = lg.user', 'left');
		if($user){
			$this->where('lg.user', $user);
        }
        if($where){
			$this->where($where);
		}

        $this->_filter()
            ->order_by([
                'date' => 'ASC',
                'code' => 'ASC',
                'user' => 'ASC',
                'address' => 'ASC'
            ])
            ->dataTable('u.name,lg.date,lg.code,lg.message,lg.address,lg.agent');
            

        $result = $this->db->get()->result();
        $this->set_dataTable();

        return $result;
    }
}