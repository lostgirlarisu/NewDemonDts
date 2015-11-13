<?php

namespace skill2001
{
	function init() 
	{
		define('MOD_SKILL2001_INFO','club;hidden;');
	}
	
	function acquire2001(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		$pa['mss']+=50;
	}
	
	function lost2001(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2001(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
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
	
	function get_ss_cost($cost=50){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if (\skillbase\skill_query(2001))	return round($cost/2);
		return $cost;
	}
	
	function calculate_attack_weapon_skill_gain(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if (\skillbase\skill_query(2001,$pa) && $pa['wep_kind']=='F') return (1+$chprocess($pa,$pd,$active));
		return $chprocess($pa,$pd,$active);
	}
}

?>
