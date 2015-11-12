<?php

namespace skill2003
{
	//升级所需技能点数值
	$upgradecost = Array(3,3,3,3,4,4,-1);
	//体力减免比例
	$spderate = Array(8,10,12,14,16,18,20);
	//歌魂回复量
	$ss_rc = Array(2,3,3,4,4,5,5);
	
	function init() 
	{
		define('MOD_SKILL2003_INFO','club;upgrade;');
		eval(import_module('clubbase'));
		$clubskillname[2003] = '音感';
	}
	
	function acquire2003(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		\skillbase\skill_setvalue(2003,'lvl','1',$pa);
	}
	
	function lost2003(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
		\skillbase\skill_delvalue(2003,'lvl',$pa);
	}
	
	function check_unlocked2003(&$pa)
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

	function upgrade2003()
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2003','player','logger'));
		if (!\skillbase\skill_query(2003))
		{
			$log.='你没有这个技能！<br>';
			return;
		}
		$clv = \skillbase\skill_getvalue(2003,'lvl');
		$ucost = $upgradecost[$clv];
		if ($clv == -1)
		{
			$log.='你已经升到满级了。<br>';
			return;
		}
		if ($skillpoint<$ucost) 
		{
			$log.='技能点不足。<br>';
			return;
		}
		$skillpoint-=$ucost; \skillbase\skill_setvalue(2003,'lvl',$clv+1);
		$log.='升级成功。<br>';
	}

	function calculate_attack_weapon_skill_gain(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger','skill2003','player'));
		if (\skillbase\skill_query(2003,$pa) && check_unlocked2003($pa)){
			$clv = \skillbase\skill_getvalue(2003,'lvl');
			$log .= "你从这场战斗中得到了灵感，恢复了{$ss_rc[$clv]}点歌魂！<br>";
			$ss+=$ss_rc[$clv];
			if($ss>$mss) $ss=$mss;
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
