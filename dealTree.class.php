<?php
/**
**@author:jack
**@date:2013-09-03
**@desc:处理无极分类
**/

class dealTree{
    public $data;
    function __construct($arr){
        $this->assign($arr);
    }
    
    function assign($arr,$order='c_order'){
        $count = count($arr);
        foreach($arr as $key=>$value){
            for($i=$key+1;$i<$count;$i++){
                if( $arr[$key][order] > $arr[$i][order]){
                    $li	 = $arr[$i];
                    $arr[$i]	= $arr[$key];
                    $arr[$key]	= $li;
                }
            }
        }
        $this->data = $arr;
    }

    #*******************************************************
    #	获得所有子节点
    #*******************************************************

    function getChildren($id = 0,$deal=0){
        $data = $this->getTreeList($id);
		if($deal==1){
			foreach($data as $key=>$val){
				foreach($data[$key] as $k=>$v){
					if($k=='depath'){
						$str	= '';
						for($i=0;$i<=$data[$key][$k];$i++){
							$str	.= '|--&nbsp;&nbsp;';
						}
						$data[$key][$k]	= $str;
					}
					
				}
			}
		}
        return $data;
    }

    function getTreeList($id = 0,$depath = 0,&$tdata = array()){
        $arr = $this->data;
        foreach($arr as $v){
            if($v['pid'] == $id){
                $v['depath']	= $depath;
                $tdata[] = $v;
                $this->getTreeList($v['cid'],$depath+1,$tdata);
            }
        }
        return $tdata;
    }
	
	

    #******************************************
    # 获得父节点
    #******************************************
    function getParent($id){
        $arr = $this->data;
        foreach ($arr as $v) {
            if ($v['cid'] == $id) return $this->getNode($v['pid']);
        }
    }
    #*************************************
    # 获得节点信息
    #*************************************
    function getNode($id){
        $arr = $this->data;
        foreach($arr as $v){
            if($v['cid'] == $id) return $v;
        }
    }

    #****************************************
    # 获得全部父节点
    #****************************************
    function getParents($id){
        while($rs = $this->getParent($id)){
            $data[] = $rs;
            $id = $rs['pid'];
        }
        return $data;
    }
}

?>