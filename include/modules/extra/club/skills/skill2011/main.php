<?php

namespace skill2011
{
	function init() 
	{
		define('MOD_SKILL2011_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2011] = '伤噬结界';
	}
	
	function acquire2011(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2011(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2011(&$pa)
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
	
	function calculate_hp_rev_dmg(&$pa, &$pd, $active)
	{
		//计算反噬伤害
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['dmg_dealt']<1000) return 0;
		$rate = 0.5;
		if ($pa['dmg_dealt']>=2000) $rate = 2.0/3.0;
		if ($pa['dmg_dealt']>=5000) $rate = 0.8;
		if (\attrbase\check_itmsk('H',$pa)){
			if(\skillbase\skill_query(2011,$pd) && check_unlocked2011($pd)){
				eval(import_module('logger'));
				if (!$active)
					$log.="<span class=\"lime\">你的「伤噬结界」使{$pd['name']}无法抵御反噬！</span><br>";
				else  $log.="<span class=\"lime\">{$pa['name']}的「伤噬结界」使你无法抵御反噬！</span><br>";
			}else{
				$rate *= 0.1;
			}
		}
		$damage = round($pa['hp']*$rate);
		if ($damage >= $pa['hp']) $damage = $pa['hp'] - 1;
		return $damage;
	}
}

?>
