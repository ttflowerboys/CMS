<?php

class site extends Admin {

    public function __construct() {
		parent::__construct();
	}
    
    public function indexAction() {
	    $list = $this->db->setTableName('site')->getAll();
	    include $this->admin_tpl('site_list');
    }
    
    public function addAction() {
        if ($this->post('submit')) {
            $data = $this->post('data');
            if (empty($data['site_name'])) $this->show_message('名称不能为空',2,1);
            if (empty($data['language'])) $this->show_message('版本名称不能为空',2,1);
            if (empty($data['site_language'])) $this->show_message('语言包名称不能为空',2,1);
            $this->db->setTableName('site')->insert($data);
	    	$this->cacheAction();
            $this->show_message('添加成功', 1, url('site'));
        }
        $file_list=glob(TEMPLATE_DIR.'*');
        $arr= array();
        foreach($file_list as $v) {
            if(is_dir($v))
            $arr[] = basename ($v);
        }
        $theme = array_diff($arr, array('mobile'));
        include $this->admin_tpl('site_add');
    }
    
    public function editAction() {
        $siteid   = (int)$this->get('siteid');
        $data = $this->db->setTableName('site')->find($siteid);
        if (empty($data)) $this->show_message('站点不存在');
        if ($this->post('submit')) {
            $data = $this->post('data');
            if (empty($data['site_name'])) $this->show_message('名称不能为空',2,1);
            if (empty($data['language'])) $this->show_message('版本名称不能为空',2,1);
            if (empty($data['site_language'])) $this->show_message('语言包名称不能为空',2,1);
            $this->db->setTableName('site')->update($data, 'siteid=?', $siteid);
	    	$this->cacheAction();
            $this->show_message('编辑成功', 1, url('site'));
        }
        $file_list=glob(TEMPLATE_DIR.'*');
        $arr= array();
        foreach($file_list as $v) {
            if(is_dir($v))
            $arr[] = basename ($v);
        }
        $theme = array_diff($arr, array('mobile'));
	    include $this->admin_tpl('site_add');
    }
    
    public function delAction() {
	    $siteid  = (int)$this->get('siteid');
        if (empty($siteid)) $this->show_message('站点ID不存在');
	    $this->db->setTableName('site')->delete('siteid=?' , $siteid);
		$this->cacheAction();
	    $this->show_message('删除成功', 1 , url('site/index'));
	}
    
    public function cacheAction() {
	    $data = array();
	    foreach ($this->db->setTableName('site')->getAll() as $t) {
	        $data[$t['siteid']] = $t;
	    }
	    set_cache('site', $data);
	}

}