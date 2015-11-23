<?php

namespace skill2017
{
	function init() 
	{
		define('MOD_SKILL2017_INFO','club;lock;hidden;');
		eval(import_module('clubbase'));
		$clubskillname[2017] = '备战成长';
	}
	
	function acquire2017(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2017(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2017(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return 1;
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
	
	function attack_finish(&$pa,&$pd,$active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		if(\skillbase\skill_query(2017,$pa) && check_unlocked2017($pa)){
			$rand_count=rand(1,4);
			$pa['mhp']+=$rand_count;
			$pa['hp']=$pa['mhp'];
		}
		
		$chprocess($pa,$pd,$active);
	}
}

?>
