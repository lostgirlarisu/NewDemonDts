<?php

namespace skill2018
{
	//发动几率(先攻/反攻)
	$skillrate=Array(100,30);
	//基础伤害率
	$damagerate=50;
	
	function init() 
	{
		define('MOD_SKILL2018_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2018] = '爆破伏击';
	}
	
	function acquire2018(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2018(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2018(&$pa)
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
		if(\skillbase\skill_query(2018,$pa) && check_unlocked2018($pa)){
			blast_raid2018($pa,$pd,$active);
		}
		if(\skillbase\skill_query(2018,$pd) && check_unlocked2018($pd)){
			blast_raid_counter2018($pa,$pd,$active);
		}
		$chprocess($pa, $pd, $active);
	}
	
	function blast_raid2018(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2018','logger'));
		//敌方的先制攻击
		$event_dice=rand(1,100);
		if (!$active && !$pa['is_counter'] && $event_dice <=$skillrate[0]) {
			//持技能的敌人先攻
			$log .= "<span class=\"yellow\">数纳竟然早已做好了伏击的准备！</span><br>
			<span class=\"yellow\">他按下遥控器的按钮引爆了预先埋设在你身处区域的C4炸弹！</span><br>";
			$damage=round($pd['mhp']*($damagerate/100));
			$log .= "遥控炸弹伏击对你造成<span class=\"red\">$damage</span>点伤害！<br>";
			$pa['skill2018_use']=1;
			$pa['skill2018_dmg']=$damage;
		}
	}
	
	function blast_raid_counter2018(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2018','logger'));
		//持有技能者【被】先攻的情况
		$event_dice=rand(1,100);
		if($active && !$pa['is_counter'] && $event_dice <=$skillrate[1]){
			//当前玩家的主动攻击
			$log .= "<span class=\"yellow\">正当你认为已经夺得先机时，却发现数纳早已做好了伏击的准备！</span><br>
			<span class=\"yellow\">在你的攻击抵达之前，你身处的区域已被强烈的爆炸覆盖！</span><br>";
			$damage=round($pa['mhp']*($damagerate/100));
			$log .= "遥控炸弹伏击对你造成<span class=\"red\">$damage</span>点伤害！<br>";
			$pd['skill2018_use']=1;
			$pd['skill2018_dmg']=$damage;
		}
	}
	
	function strike_finish(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		skill_calculate2018($pa,$pd,$active);
		
		$chprocess($pa, $pd, $active);
	}
	
	function skill_calculate2018(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger'));
		//伤害结算
		//持有技能者先攻的情况
		if (\skillbase\skill_query(2018,$pa) && check_unlocked2018($pa) && $pa['skill2018_use']){
			$pa['dmg_dealt']+=$pa['skill2018_dmg'];
		}
		//持有技能者反击的情况
		if (\skillbase\skill_query(2018,$pd) && check_unlocked2018($pd) && $pd['skill2018_use']){
			if (!\battle\check_can_counter($pd,$pa,$active)){
				//如果$pa在不能反击的情况下却发动了技能，则强行呼出伤害结算函数
				$pd['dmg_dealt']+=$pd['skill2018_dmg'];
				\attack\player_damaged_enemy($pd,$pa,$active);
			}else{
				$pd['dmg_dealt']+=$pd['skill2018_dmg'];
			}
		}
	}
}

?>
