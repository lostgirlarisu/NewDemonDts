<?php

namespace skill2003
{
	//歌魂回复量
	$ss_rc=5;
	
	function init() 
	{
		define('MOD_SKILL2003_INFO','club;');
		eval(import_module('clubbase'));
		$clubskillname[2003] = '灵感';
	}
	
	function acquire2003(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		
	}
	
	function lost2003(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2003(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return $pa['lvl']>=3;
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
/*	
	function player_attack_enemy(&$pa,&$pd,$active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger','skill2003'));
		$log .= "你从这场战斗中得到了灵感，增加了5点歌魂！";
		$chprocess($pa,$pd,$active);
	}
*/	
	function calculate_attack_weapon_skill_gain(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger','skill2003','player'));
		if (\skillbase\skill_query(2003,$pa) && check_unlocked2003($pa)){
			if(check_ss_equip()){
				$log .= "你从这场战斗中得到了灵感，恢复了{$ss_rc}点歌魂！<br>";
				$ss+=$ss_rc;
				if($ss>$mss) $ss=$mss;
			}
		}
		return $chprocess($pa,$pd,$active);
	}
/*
	function get_ss_rc(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2003'));
		//只是为了desc可以获取这个值才写的
		return $ss_rc;
	}
*/

	function check_ss_equip2003(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player'));
		//检查有没有装备歌词卡
		if($artk == 'ss') return 1;
		else return 0;
	}
}

?>
