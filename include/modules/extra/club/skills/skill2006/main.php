<?php

namespace skill2006
{
	function init() 
	{
		define('MOD_SKILL2006_INFO','club;');
		eval(import_module('clubbase'));
		$clubskillname[2006] = '言灵';
	}
	
	function acquire2006(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2006(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2006(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return $pa['lvl']>=15;
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
	function get_weapon_range(&$pa, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('weapon'));
		if (isset($pa['wep_kind']))
			
			eval(import_module('logger'));
			if(check_unlocked2006($pa)){
				$log .="武器种类对";
			}else{$log .="武器种类不对";}
			
			if ($pa['wep_kind']=='F' && \skillbase\skill_query(2006,$pa) && check_unlocked2006($pa)){
				eval(import_module('logger'));
				if ($active)
					$log.='<span class="yellow">「言灵」使你的武器攻击距离提高了！</span><br>';
				else  $log.='<span class="yellow">「言灵」使敌人的武器攻击距离提高了！</span><br>';
				return $rangeinfo['C'];
			}
		$chprocess($pa,$active);
	}*/
	/*
	function get_physical_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$r=Array();
		//if ($pa['wep_kind']=='F' && \skillbase\skill_query(2006,$pa) && check_unlocked2006($pa)) 
		//{
			eval(import_module('logger'));
			if ($active)
				$log.='<span class="yellow">「言灵」使你造成的基础伤害提高了20%！</span><br>';
			else  $log.='<span class="yellow">「言灵」使敌人造成的基础伤害提高了20%！</span><br>';
			$r=Array(1.2);
		//}
		return array_merge($r,$chprocess($pa,$pd,$active));
	}*/
}

?>
