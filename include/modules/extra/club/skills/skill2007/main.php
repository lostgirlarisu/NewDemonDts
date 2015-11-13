<?php

namespace skill2007
{
	//怒气消耗
	$ragecost=0;//50
	//歌魂消耗上限
	$sscost_limit=75;//75
	
	function init() 
	{
		define('MOD_SKILL2007_INFO','club;battle;');
		eval(import_module('clubbase'));
		$clubskillname[2007] = '安魂';
	}
	
	function acquire2007(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2007(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2007(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return $pa['lvl']>=20;
	}
	
	function skill_onload_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加载入一个人物时的动作
		$chprocess($pa);
	}
	
	function skill_onsave_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加保存一个人物时的动作
		$chprocess($pa);
	}
	
	function finalsong(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
	}
	
	function get_rage_cost2007(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2007'));
		return $ragecost;
	}
	
	function get_ss_cost2007(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2007'));
		return $sscost_limit;
	}
	
	function check_ss_equip2007(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player'));
		//检查有没有装备歌词卡
		if($artk == 'ss') return 1;
		else return 0;
	}
}

?>
