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
		
		//由于代码逻辑使然，不论玩家或NPC，从代码基础外层导入的先攻方为$pa
		//所以NPC专用技需要根据情况两边都检测一次才能确保不会出现玩家先攻的情况下NPC不发动技能
		skill_effect2017($pa);
		skill_effect2017($pd);
		$chprocess($pa,$pd,$active);
	}
	
	function skill_effect2017(&$pa){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger'));
		
		//$log.="DEBUG:skill2017结点01<br>";
		if(\skillbase\skill_query(2017,$pa) && check_unlocked2017($pa)){
			//$log.="DEBUG:{$pa['name']}回血了<br>";
			$rand_count=rand(1,4);
			$pa['mhp']+=$rand_count;
			$pa['hp']=$pa['mhp'];
		}
	}
}

?>
