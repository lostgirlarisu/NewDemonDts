<?php

namespace skill2019
{
	//最小减少值
	$de_min=50;
	//最大减少值
	$de_max=250;
	
	function init() 
	{
		define('MOD_SKILL2019_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2019] = '念动衰竭';
	}
	
	function acquire2019(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2019(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2019(&$pa)
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
	
	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//只限持技能者先攻的情况下发动
		if(\skillbase\skill_query(2019,$pa) && check_unlocked2019($pa)){
			skill_effect2019($pa,$pd,$active);
		}
		$chprocess($pa, $pd, $active);
	}
	
	function skill_effect2019(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2019','logger'));
			
		$log .= "<span class=\"yellow\">北大路抬起手，掌心朝向你，你感到一阵眩晕！</span><br>";
		$de=rand($de_min,$de_max);
		if ($de>=$pd['mhp']) $de=$pd['mhp']-1;
		$pa['de_skill2019']=$de;
		$log .= "<span class=\"yellow\">回过神来，你发现你的体能受到了超能力的影响，生命上限减少了{$de}点！</span><br>";
		$pd['mhp']-=$pa['de_skill2019'];
		if ($pd['hp']>$pd['mhp']) $pd['hp']=$pd['mhp'];
	}
	
	function strike_finish(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		$chprocess($pa, $pd, $active);
		//先进行伤害计算再发生回复上限流程
		skill_recover2019($pa, $pd, $active);
	}
	
	function skill_recover2019(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2019','logger'));
	
		if ($pd['hp']>0 && $pa['de_skill2019']>0){
			$log .= "<span class=\"yellow\">超能力的效果解除后，你的生命上限也恢复了！</span><br>";
			$pd['mhp']+=$pa['de_skill2019'];
			$pa['de_skill2019']=0;//重置
		}
	}
}

?>
