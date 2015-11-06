<?php

namespace skill2002
{
	function init() 
	{
		define('MOD_SKILL2002_INFO','club;upgrade;');
		eval(import_module('clubbase'));
		$clubskillname[2002] = '歌喉';
	}
	
	function acquire2002(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2002(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2002(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		//if(\skillbase\skill_query(2002))  return 1;
		//else return 0;
		//return $pa['lvl']>=3;
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
	
	function upgrade2002(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player','logger'));
		if (!\skillbase\skill_query(2002))
		{
			$log.='你没有这个技能！<br>';
			return;
		}
		if ($skillpoint<1) 
		{
			$log.='技能点不足。<br>';
			return;
		}
		$mss_up = 10;
		$mss += $mss_up;
		$log.='消耗了<span class="lime">1</span>点技能点，你的歌魂上限提升了<span class="yellow">'.$mss_up.'</span>点。<br>';
		$skillpoint--;
	}

}

?>
