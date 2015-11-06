<?php

namespace skill2005
{
	function init() 
	{
		define('MOD_SKILL2005_INFO','club;');
		eval(import_module('clubbase'));
		$clubskillname[2005] = '专业';
	}
	
	function acquire2005(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2005(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2005(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return $pa['lvl']>=11;
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
	
	function calculate_hp_rev_dmg(&$pa, &$pd, $active)
	{
		//计算反噬伤害
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval (import_module('logger','skill2005'));
		if ($pa['dmg_dealt']<1000) return 0;
		$rate = 0.5;
		if ($pa['dmg_dealt']>=2000) $rate = 2.0/3.0;
		if ($pa['dmg_dealt']>=5000) $rate = 0.8;
		if (\attrbase\check_itmsk('H',$pa) || check_skill_effect2005($pa)) $rate *= 0.1;
		if (check_skill_effect2005($pa)){
			$log .= "由于<span class=\"yellow\">专业</span>的效果使你抵挡了一定程度的反噬！";
		}
		$damage = round($pa['hp']*$rate);
		if ($damage >= $pa['hp']) $damage = $pa['hp'] - 1;
		return $damage;
	}
	
	function check_ss_equip2005(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player'));
		//检查有没有装备歌词卡
		if($artk == 'ss') return 1;
		else return 0;
	}
	
	function check_skill_effect2005(&$pa){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player','skill2005','logger'));
		//用于检测本技能有没有生效
		//$log .= json_encode($pa);
		if(check_ss_equip2005() || \skillbase\skill_query(2005,$pa) || check_unlocked2005($pa)){
			return 1;
		}else {
			return 0;		 	
		}
	}
}

?>
