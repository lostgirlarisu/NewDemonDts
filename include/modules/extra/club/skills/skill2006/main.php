<?php

namespace skill2006
{
	//升级所需技能点数值
	$upgradecost = Array(5,5,-1);
	//灵系物理伤害提升
	$atk_up2006 = Array(10,15,20);
	//灵系射程变更
	$range_change2006 = Array(3,4,5);
	
	function init() 
	{
		define('MOD_SKILL2006_INFO','club;upgrade;');
		eval(import_module('clubbase'));
		$clubskillname[2006] = '言灵';
	}
	
	function acquire2006(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		\skillbase\skill_setvalue(2006,'lvl','0',$pa);
	}
	
	function lost2006(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
		\skillbase\skill_delvalue(2006,'lvl',$pa);
	}
	
	function check_unlocked2006(&$pa)
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
	
	function upgrade2006()
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2006','player','logger'));
		if (!\skillbase\skill_query(2006))
		{
			$log.='你没有这个技能！<br>';
			return;
		}
		$clv = \skillbase\skill_getvalue(2006,'lvl');
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
		$skillpoint-=$ucost; \skillbase\skill_setvalue(2006,'lvl',$clv+1);
		$log.='升级成功。<br>';
	}
	
	function get_weapon_range(&$pa, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('weapon','skill2006'));
		if (isset($pa['wep_kind'])){
			/*
			eval(import_module('logger'));
			if(check_unlocked2006($pa)){
				$log .="DEBUG:「".$pa['name']."」的调试项为TRUE<br>";
			}else{$log .="DEBUG:「".$pa['name']."」的调试项为FALSE<br>";}
			*/
			if ($pa['wep_kind']=='F' && \skillbase\skill_query(2006,$pa) && check_unlocked2006($pa) && $pa['artk']=='ss'){
				eval(import_module('logger'));
				/*
				if ($active)
					$log.='<span class="yellow">「言灵」使你的武器攻击距离提高了！</span><br>';
				else  $log.='<span class="yellow">「言灵」使敌人的武器攻击距离提高了！</span><br>';
				*/
				$clv = \skillbase\skill_getvalue(2006,'lvl');
				return $range_change[$clv];
			}
		}
		$chprocess($pa,$active);
	}
	
	function get_physical_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$r=Array();
		if ($pa['wep_kind']=='F' && \skillbase\skill_query(2006,$pa) && check_unlocked2006($pa) && $pa['artk']=='ss'){
			eval(import_module('logger','skill2006'));
			$clv = \skillbase\skill_getvalue(2006,'lvl');
			$up_text=$atk_up2006[$clv];//文字显示
			if ($active)
				$log.="<span class=\"yellow\">「言灵」使你造成的基础伤害提高了{$up_text}%！</span><br>";
			else  $log.="<span class=\"yellow\">「言灵」使敌人造成的基础伤害提高了{$up_text}%！</span><br>";
			$r=Array(1+$atk_up2006[$clv]/100);
		}
		return array_merge($r,$chprocess($pa,$pd,$active));
	}
	
	function check_ss_equip2006(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player'));
		//检查有没有装备歌词卡
		if($artk == 'ss') return 1;
		else return 0;
	}
}

?>
