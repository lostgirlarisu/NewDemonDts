<?php

namespace skill2007
{
	//怒气消耗
	$ragecost=50;//50
	//歌魂消耗上限
	$sscost_limit=75;//75
	//对NPC最大伤害提升率
	$max_dmgrate=300;//300
	
	function init() 
	{
		define('MOD_SKILL2007_INFO','club;battle;');
		eval(import_module('clubbase'));
		$clubskillname[2007] = '安魂';
	}
	
	function acquire2007(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		\skillbase\skill_setvalue(2007,'rmtime','1',$pa);
	}
	
	function lost2007(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2007(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return $pa['lvl']>=20;
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
		
	function get_rage_cost2007(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2007'));
		return $ragecost;
	}
	
	function get_ss_cost2007(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2007','player'));
		if ($ss>=$sscost_limit){
			return $sscost_limit;
		}else {
		 	return $ss;
		}
	}
	
	function get_remaintime2007(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		return \skillbase\skill_getvalue(2007,'rmtime',$pa);
	}
	
	function check_ss_equip2007(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player'));
		//检查有没有装备歌词卡
		if($artk == 'ss') return 1;
		else return 0;
	}
	
	function count_dmg_rate2007(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//用来返回给battlecmd显示的
		eval(import_module('skill2007','player'));
		
		$dmg_rate2007 = array(get_ss_cost2007(),round(get_ss_cost2007()/$sscost_limit*$max_dmgrate));
		return $dmg_rate2007;
	}
	
	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']!=2007) return $chprocess($pa, $pd, $active);
		if (!\skillbase\skill_query(2007,$pa) || !check_unlocked2007($pa))
		{
			eval(import_module('logger'));
			$log .= '你尚未解锁这个技能！';
			$pa['bskill']=0;
		}
		else
		{
			$remtime = (int)get_remaintime2007($pa);
			$rcost = get_rage_cost2007($pa);
			if ($remtime>=1 && $pa['rage']>=$rcost && $pa['artk']=='ss')
			{
				eval(import_module('logger','skill2007'));
				if ($active)
					$log.="<span class=\"lime\">你对{$pd['name']}发动了技能「安魂」！</span><br>";
				else  $log.="<span class=\"lime\">{$pa['name']}对你发动了技能「安魂」！</span><br>";
				$pa['rage']-=$rcost;
				$remtime--;
				\skillbase\skill_setvalue(2007,'rmtime',$remtime,$pa);
				if($pd['type']!=0){
					$text_tmp='';
				}else {
					//对玩家发动安魂技能的附加文字
				 	$text_tmp='，造成了强制生命削减';
				}
				addnews ( 0, 'bskill2007', $pa['name'], $pd['name'], $text_tmp);
				finalsong_for_player($pa, $pd, $active);
			}
			else
			{
				if ($active)
				{
					eval(import_module('logger'));
					$log.='怒气不足或其他原因不能发动。<br>';
				}
				$pa['bskill']=0;
			}
		}
		$chprocess($pa, $pd, $active);
	}

	function finalsong_for_player(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//因为不知道该接管哪个函数所以只好额外开了一个
		//该函数是技能对玩家起作用时的效果
		eval(import_module('skill2007','logger','attack'));
		if ($pa['bskill']==2007 && $pd['type']==0){
			if($pa['ss']>$sscost_limit){
				$var_2007=$sscost_limit;
				$pa['ss']-=$sscost_limit;
			}else{
				$var_2007=$pa['ss'];
				$pa['ss']=0;
			}
			$dmg=round($pd['mhp']*$var_2007/100);
			if ($active)
				$log.=json_encode($pa)."<span class=\"yellow\">「安魂」使敌人受到了{$dmg}点伤害！</span><br>";
			else  $log.="<span class=\"yellow\">「安魂」使你受到了{$dmg}点伤害！</span><br>";
			
			$pd['hp']-=$dmg;
		}
	}

	function get_final_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2007'));
		$r=Array();
		if ($pa['bskill']==2007 && $pd['type']!=0) 
		{
			eval(import_module('logger'));
			if($pa['ss']>$sscost_limit){
				$var_2007=$max_dmgrate;
				$pa['ss']-=$sscost_limit;
			}else{
				$var_2007=round($pa['ss']/$sscost_limit*$max_dmgrate);
				$pa['ss']=0;
			}
			if ($active)
				$log.="<span class=\"yellow\">「安魂」使你造成的最终伤害提高了{$var_2007}%！</span><br>";
			else  $log.="<span class=\"yellow\">「安魂」使敌人造成的最终伤害提高了{$var_2007}%！</span><br>";
			$var_2007=$var_2007/100;
			$r=Array($var_2007);
		}
		return array_merge($r,$chprocess($pa,$pd,$active));
	}
	
	function parse_news($news, $hour, $min, $sec, $a, $b, $c, $d, $e)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('sys','player'));
		
		if($news == 'bskill2007') 
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"clan\">{$a}对{$b}发动了技能<span class=\"yellow\">「安魂」</span>{$c}</span><br>\n";
		
		return $chprocess($news, $hour, $min, $sec, $a, $b, $c, $d, $e);
	}
}

?>
