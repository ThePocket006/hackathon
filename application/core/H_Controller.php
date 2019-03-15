<?php
	/**
	 * Created by PhpStorm.
	 * User: Harrys
	 * Date: 12/01/2019
	 * Time: 19:48
	 */

class H_Controller extends CI_Controller
{
    protected $headerCss = '';
    protected $headerJs = '';
    protected $data;
    protected $zone;

    public function __construct()
    {
        parent::__construct();
        $this->zone="";
    }


    protected function loggout()
    {
        $this->session->session_destroy();
    }

    /**
     * @param $src
     * @param string $type
     */
    protected function linker($name, $type = 'css')
    {

        if(is_string($name) And $name) {
            $name = explode(',', $name);
        }

        foreach ((array)$name as $item)
            $this->_linker($item, $type);
    }

    protected function front_linker($name, $type = 'css')
    {
        $this->linker('themes/front/'.$name, $type);
    }

    private function _linker($name, $type = 'css')
    {
        $type = strtolower($type);
        if(in_array($type, ['css', 'js'])) {
            switch ($type) {
                case 'css':
                    $this->headerCss .= '<link rel="stylesheet" href="' . css_url($name) . '" media="all" />'."\n";
                    break;
                case 'js':
                    $this->headerJs .= '<script type="application/javascript" src="' . js_url($name) . '"></script>'."\n";
                    break;
                default:
                    break;
            }
        }
    }

    protected function file_upload($directory, $field, $filename="", $allowed_ext=EXT_ALL, $max_size=5128000, $max_width="5128", $max_heigth="5128")
    {
        $config = array(
            'upload_path' => ".".$directory,
            'allowed_types' => $allowed_ext,
            'overwrite' => TRUE,
            'max_size' => $max_size, // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => $max_width,
            'max_width' => $max_heigth,
        );
        if (!empty($filename))
            $config['file_name']=$filename;
        $this->load->library('upload', $config);
        if($this->upload->do_upload($field))
        {
            $data = (object) $this->upload->data();
            $data->type=UPLOAD_SUCCESS;
        }
        else
        {
            $data = (object) $this->upload->display_errors();
            $data->type=UPLOAD_ERROR;
        }
        return $data;
    }

    protected function verbose(...$params)
    {
        echo '<pre>';
        foreach ((array) $params as $k=>$p)
            var_dump($p);
        echo '</pre>';
        die;
    }
}

class H_Controller_Front extends H_Controller
{
	protected $js = false;
	protected $js_data = [];

	public function __construct()
	{
		parent::__construct();
		$this->zone = '';

//		$this->config->set_item('csrf_protection', TRUE);

		$this->linker('sweetalert2.all', 'js');
	}

	protected function render($view = 'index', $title = "Sans titre", $menus = TRUE, $footer = TRUE){
		$view = ($view && is_string($view))?$view:'index';

		$this->load->view("header", ["title"=>$title, 'headerCss'=>$this->headerCss]);
		if($menus === TRUE) $this->load->view("top-menu");
		$this->execute(($this->zone?$this->zone.'/':'').$view);
		$this->load->view("footer", ['headerJs'=>$this->headerJs, 'footer'=>$footer]);
	}

	protected function execute($view, $return = FALSE)
	{
		if($this->js === TRUE) {
			$tmp1 = explode('/', $view);
			$tmp2 = array_pop($tmp1);
			$tmp1 = implode('/', $tmp1);
			$this->headerJs .= "\n\t" . $this->load->view(($tmp1?$tmp1.'/':'') . "js/".$tmp2.'_js', $this->js_data, TRUE);
		}
		return $this->load->view($view, $this->data, $return);
	}
}

	class H_Controller_Admin extends H_Controller{
		public function __construct()
		{
			parent::__construct();
		}

		protected function render($view, $title="Sans titre", $single_page=false){
			$this->data['title']=$title;
			if ($single_page)
			{
				$this->load->view('admin/'.$this->zone.'/'.$view, $this->data);
			} else {
				$this->load->view('admin/header', ["title"=>$title]);
				$this->load->view('admin/side');
				$this->load->view('admin/top', ["title"=>$title]);
				$this->load->view('admin/'.$this->zone.'/'.$view, $this->data);
				$this->load->view('admin/footer');
			}
		}
	}
