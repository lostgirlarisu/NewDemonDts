<?php

namespace skill2016
{
	//发动几率
	$skillrate=30;
	//基础伤害率
	$damagerate=30;
	
	function init() 
	{
		define('MOD_SKILL2016_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2016] = '支援空袭';
	}
	
	function acquire2016(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2016(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2016(&$pa)
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
		if(\skillbase\skill_query(2016,$pa) && check_unlocked2016($pa)){
			air_raid2016($pa,$pd,$active);
		}
		$chprocess($pa, $pd, $active);
	}
	
	function air_raid2016(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2016','logger'));
	
		$event_dice=rand(1,100);
		if($event_dice <=$skillrate){
				$log .= "<span class=\"yellow\">“制空权已确保！立即对敌进行饱和空袭攻击！”无聊大手一挥作出了战斗指示！</span><br>";
				$log .= "<span class=\"yellow\">数架无人轰炸机从低空呼啸而过，炮火淹没了你！！</span><br>";
				$damage=round($pd['mhp']*($damagerate/100));
				$log .= "轰炸机空袭对你造成<span class=\"red\">$damage</span>点伤害！<br>";
				$pa['skill2016_use']=1;
				$pa['skill2016_dmg']=$damage;
		}else{
			$pa['skill2016_use']=0;
		}
	}
	
	function strike_finish(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if (\skillbase\skill_query(2016,$pa) && check_unlocked2016($pa) && $pa['skill2016_use'])
		{
			$pa['dmg_dealt']+=$pa['skill2016_dmg'];
		}
		$chprocess($pa, $pd, $active);
	}
}

?>
