<?php

namespace skill2004
{
	$ragecost=0;//5
	$sscost=0;//20
	
	function init() 
	{
		define('MOD_SKILL2004_INFO','club;battle;');
		eval(import_module('clubbase'));
		$clubskillname[2004] = '战歌';
	}
	
	function acquire2004(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2004(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2004(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return $pa['lvl']>=7;
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
	
	function get_rage_cost2004(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2004'));
		return $ragecost;
	}
	
	function get_ss_cost2004(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2004'));
		return $sscost;
	}

	function check_ss_equip2004(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player'));
		//检查有没有装备歌词卡
		/*
		eval(import_module('logger'));
		$log .= "目前变量pa是".json_encode($pa);
		$log .= "<br>rage是{$pa['rage']}";
		if($pa['artk'] == 'ss') return 1;
		//if($artk == 'ss') return 1;
		else return 0;
		*/
		return 1;
	}

	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']!=2004) return $chprocess($pa, $pd, $active);
		if (!\skillbase\skill_query(2004,$pa) || !check_unlocked2004($pa))
		{
			eval(import_module('logger'));
			$log .= '你尚未解锁这个技能！';
			$pa['bskill']=0;
		}
		else
		{
			$rcost = get_rage_cost2004($pa);
						eval(import_module('logger'));
			$log .= '你尚未解锁这个技能！';
			if (($pa['rage']>=$rcost)&&(1))
			{
				eval(import_module('logger'));
				if ($active)
					$log.="<span class=\"lime\">你对{$pd['name']}发动了技能「战歌」！</span><br>";
				else  $log.="<span class=\"lime\">{$pa['name']}对你发动了技能「战歌」！</span><br>";
				$pa['rage']-=$rcost;
				$pa['ss']-=$sscost;
				//addnews ( 0, 'bskill2004', $pa['name'], $pd['name'] );
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
	

}

?>
