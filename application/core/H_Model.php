<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $table_prefix = '';
    protected $table_log    = 'log';
    protected $table_user   = 'user';
    protected $table_contenu = 'contenu';
    protected $table_copie_courrier = 'copie_courrier';
    protected $table_cotation = 'cotation';
    protected $table_courrier = 'courrier';
    protected $table_decharge = 'decharge';
    protected $table_destinataire   = 'destinataire';
    protected $table_etat_traitement    = 'etat_traitement';
    protected $table_exterieur  = 'exterieur';
    protected $table_message    = 'message';
    protected $table_piece_jointe   = 'piece_jointe';
    protected $table_piece_message  = 'piece_message';
    protected $table_recepteur_message = 'recepteur_message';
    protected $table_role = 'role';
    protected $table_traitement_courrier = 'traitement_courrier';
    protected $table_type_courrier = 'type_courrier';

    protected $subquery;

    protected $dataTable = 'dataTable';
    private $aData = [];
    protected $is_dataTable = false;

    private $select = [];
    private $from = [];
    private $join = [];
    private $where = [];
    private $or_where = [];
    private $like = [];
    private $or_like = [];
    private $order_by = [];

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('Subquery');

        $this->load->helper('security');
        $this->ini_dataTable();
    }

    public function select($select = '*', $escape = NULL)
    {
        $this->select[] = [$select, $escape];
        $this->db->select($select, $escape);
        return $this;
    }

    private function _select()
    {
        foreach ($this->select as $item)
            $this->db->select($item[0], $item[1]);
        return $this;
    }

    public function from($from)
    {
        $this->from[] = $from;
        $this->db->from($from);
        return $this;
    }

    private function _from()
    {
        foreach ($this->from as $item)
        $this->db->from($item);
        return $this;
    }

    public function join($table, $cond, $type = '', $escape = NULL)
    {
        $this->join[] = [$table, $cond, $type, $escape];
        $this->db->join($table, $cond, $type, $escape);
        return $this;
    }

    private function _join()
    {
        foreach ($this->join as $item)
            $this->db->join($item[0], $item[1], $item[2], $item[3]);
        return $this;
    }

    public function where($key = '', $data='')
    {
        $this->where[] = [$key, $data];
        $this->_db_where($key, $data);
        return $this;
    }

    private function _where()
    {
        foreach ($this->where as $item)
            $this->_db_where($item[0], $item[1]);
        return $this;
    }

    private function _db_where($key = '', $data='')
    {
        if($key){
            if(is_string($key)){
                if (is_string($data) Or is_numeric($data)) {
                    $this->db->where($key, $data);
                } elseif (is_array($data)) {
                    $this->db->where_in($key, $data);
                }else{
                    $this->db->where($key);
                }
            }elseif(is_array($key)) {
                foreach ($key as $k => $value){
                    if(!is_numeric($k)){
                        $this->where($k, $value);
                    }
                }
            }
        }
    }

    public function or_where($key = '', $data='')
    {
        $this->or_where[] = [$key, $data];
        $this->_db_or_where($key, $data);
        return $this;
    }

    private function _or_where()
    {
        foreach ($this->or_where as $item)
            $this->_db_or_where($item[0], $item[1]);
        return $this;
    }

    private function _db_or_where($key = '', $data='')
    {
        if($key){
            if(is_string($key)){
                if(is_string($data) Or is_numeric($data)) {
                    $this->db->or_where($key, $data);
                } elseif (is_array($data)) {
                    $this->db->or_where_in($key, $data);
                }else{
                    $this->db->or_where($key);
                }
            }elseif(is_array($key)) {
                foreach ($key as $k => $value){
                    if(!is_numeric($k)){
                        $this->or_where($k, $value);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * ORDER BY
     *
     * @param	string|array	$orderby
     * @param	string	$direction	ASC, DESC or RANDOM
     * @param	bool	$escape
     */
    public function order_by($orderby = '', $direction = 'ASC', $escape = NULL)
    {
        $this->order_by[] = [$orderby, $direction, $escape];
        if(!$this->is_dataTable) {
            $this->_db_order_by($orderby, $direction, $escape);
        }
        return $this;
    }

    private function _order_by()
    {
        foreach ($this->order_by as $item)
            $this->_db_order_by($item[0], $item[1], $item[2]);
        return $this;
    }

    private function _db_order_by($orderby = '', $direction = 'ASC', $escape = NULL)
    {
        $direct = ['ASC', 'DESC', 'RANDOM'];
        if(is_array($orderby)){
            foreach ($orderby as $key => $value) {
                $k = strtoupper($value);
                if(in_array($k, $direct)){
                    $this->db->order_by($key, $k, $escape);
                }else {
                    $this->db->order_by($key, $direction, $escape);
                }
            }
        }elseif(is_string($orderby)){
            $this->db->order_by($orderby, $direction, $escape);
        }
        return $this;
    }

    public function like($field = '', $match = '', $side = 'both', $escape = NULL)
    {
        $this->like[] = [$field, $match, $side, $escape];
        $this->_db_like($field, $match, $side, $escape);
        return $this;
    }

    private function _like()
    {
        foreach ($this->like as $item)
            $this->_db_like($item[0], $item[1], $item[2], $item[3]);
        return $this;
    }

    private function _db_like($field = '', $match = '', $side = 'both', $escape = NULL)
    {
        if($field) {
            $field = $this->select_parser($field);
            foreach ($field as $title => $item) {
                if(!is_numeric($title) And (is_string($item) Or is_numeric($item)))
                    $this->db->like($title, $item, $side, $escape);
                elseif(!is_numeric($item) And (is_string($match) Or is_numeric($match)))
                    $this->db->like($item, $match, $side, $escape);
            }
        }
        return $this;
    }

    public function or_like($field = '', $match = '', $side = 'both', $escape = NULL)
    {
        $this->or_like[] = [$field, $match, $side, $escape];
        $this->_db_or_like($field, $match, $side, $escape);
        return $this;
    }

    private function _or_like()
    {
        foreach ($this->or_like as $item)
            $this->_db_or_like($item[0], $item[1], $item[2], $item[3]);
        return $this;
    }

    private function _db_or_like($field = '', $match = '', $side = 'both', $escape = NULL)
    {
        if($field) {
            $field = $this->select_parser($field);
            foreach ($field as $title => $item) {
                if(!is_numeric($title) And (is_string($item) Or is_numeric($item)))
                    $this->db->or_like($title, $item, $side, $escape);
                elseif(!is_numeric($item) And (is_string($match) Or is_numeric($match)))
                    $this->db->or_like($item, $match, $side, $escape);
            }
        }
        return $this;
    }

    public function dataTable($searchFlieds = "")
    {
        $this->get_paging()
            ->get_filtering($searchFlieds)
            ->get_ordering();
        return $this;
    }

    public function set_dataTableaData(array $aData = [])
    {
        $this->aData = $aData;
    }

    public function set_dataTable(array $orderData = [])
    {
        if($this->is_dataTable){
            $data = [];
            foreach ($orderData as $key => $item) {
                if(!is_numeric($key))
                    $data[$key] = $item;
            }

            $data['draw'] = intval($this->input->post('draw'));
            $data['recordsTotal'] = $this->recordsTotal();
            $data['recordsFiltered'] = $this->recordsFiltered();
            set_session_data([$this->dataTable => $data]);
        }
    }

    private function recordsTotal()
    {
        $this->db->reset_query()->select('COUNT(*) as COUNT');
        return (int)$this->db->get($this->from)->result()[0]->COUNT;
    }

    private function recordsFiltered()
    {
        $this->db->reset_query()->select('COUNT(*) as COUNT');
        $this->fromAndJoin()->whereAndLike();
        return (int)$this->db->get()->result()[0]->COUNT;
    }

    private function fromAndJoin()
    {
        $this->_from()
            ->_join();
        return $this;
    }

    private function whereAndLike()
    {
        $this->_where()
            ->_or_where()
            ->_like()
            ->_or_like();
        return $this;
    }

    protected function vardump(...$expression)
    {
        $nb = count($expression)-1;
        $i = 0;
        echo "<pre>";
        foreach ($expression as $item) {
            if($i++ != $nb Or $expression[$nb] !== true)
                var_dump($item);
        }
        echo "</pre>";
        if($expression[$nb] !== true)
            die();
    }

    public function _filter($methodName = '')
    {
        if($this->is_dataTable) {
            if(!$methodName) $methodName = sha1($this->uri->uri_string());
			$this->where(session_data($methodName.'_filter'));
		}
        return $this;
    }

    private function get_paging()
    {
        if($this->is_dataTable) {
            $iStart = $this->input->post('start');
            $iLength = $this->input->post('length');

            if ($iLength != '' && $iLength != '-1')
                $this->db->limit($iLength, ($iStart) ? $iStart : 0);
        }
        return $this;
    }

    private function get_ordering()
    {
        if($this->is_dataTable) {
            $count = 0;
            if ($this->input->post('order')) {
                foreach ($this->input->post('order') as $key) {
                    if (isset($this->aData[$key['column']])) {
                        $count++;
                        $this->db->order_by($this->aData[$key['column']], $key['dir']);
                    }
                }
            }
            if($count == 0) $this->_order_by();
        }
        return $this;
    }

    private function get_filtering($searchFlieds = "")
    {
        if($this->is_dataTable) {
            $search = $this->input->post('search');
            $sSearch = $this->db->escape_like_str(trim($search['value']));

            if ($sSearch) {
                $this->db->group_start();
                $this->or_like($this->select_parser($searchFlieds), $sSearch);
                $this->db->group_end();
            }
        }

        return $this;
    }

    private function ini_dataTable(){
        $this->form_validation->reset_validation();
        $this->form_validation->set_rules("dataTable", "", 'trim|required|mb_strtolower|regex_match[/true/]|xss_clean|encode_php_tags');
        if($this->form_validation->run())
            $this->is_dataTable = true;

        if($this->input->post('aData') And is_array($this->input->post('aData'))) {
            $this->form_validation->reset_validation();
            foreach ($this->input->post('aData') as $key => $item){
                $this->form_validation->set_rules("aData[$key]", "", "trim|is_string|xss_clean|encode_php_tags");
            }
            if($this->form_validation->run())
                $this->set_dataTableaData($this->input->post('aData'));
        }

        $this->form_validation->reset_validation();
    }

    private function select_parser($select = '', $separator = '|,'){
        if(is_array($select)) return $select;

        if(is_string($separator))
            $separator = str_split($separator);
        elseif(!is_array($separator))
            $separator = (array)$separator;

        if(is_array($select) And count($separator)>0)
            $select = implode($separator[0], $select);
        elseif(!is_string($select))
            $select = (string)$select;

        $select = str_replace([' '], '', $select);

        foreach ($separator as $item) {
            $item = trim($item);
            if(count($data = explode($item, $select))>1)
                return $data;
        }
        return (array) $select;
    }

    public function _reset()
    {
        $this->select = [];
        $this->from = [];
        $this->join = [];
        $this->where = [];
        $this->or_where = [];
        $this->like = [];
        $this->or_like = [];
        $this->order_by = [];
        return $this;
    }

    public function query($sql, $binds = FALSE, $return_object = NULL)
    {
        return $this->db->query($sql, $binds, $return_object)->result();
    }
}