<?php

namespace skill237
{
	//怒气消耗
	$ragecost = 30; 
	
	function init() 
	{
		define('MOD_SKILL237_INFO','club;battle;');
		eval(import_module('clubbase'));
		$clubskillname[237] = 'EMP';
	}
	
	function acquire237(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
	}
	
	function lost237(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
	}
	
	function skill_onload_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$chprocess($pa);
	}
	
	function skill_onsave_event(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$chprocess($pa);
	}
	
	function check_unlocked237(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		return $pa['lvl']>=11;
	}
	
	function get_rage_cost237(&$pa = NULL)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill237'));
		return $ragecost;
	}
	
	function strike_prepare(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']!=237) return $chprocess($pa, $pd, $active);
		if (!\skillbase\skill_query(237,$pa) || !check_unlocked237($pa))
		{
			eval(import_module('logger'));
			$log .= '你尚未解锁这个技能！';
			$pa['bskill']=0;
		}
		else
		{
			$rcost = get_rage_cost237($pa);
			if ($pa['rage']>=$rcost)
			{
				eval(import_module('logger'));
				if ($active)
					$log.="<span class=\"lime\">你对{$pd['name']}发动了技能「EMP」！</span><br>";
				else  $log.="<span class=\"lime\">{$pa['name']}对你发动了技能「EMP」！</span><br>";
				$pa['rage']-=$rcost;
				addnews ( 0, 'bskill237', $pa['name'], $pd['name'] );
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
	
	function get_physical_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$r=Array();
		if ($pa['bskill']==237) 
		{
			eval(import_module('logger'));
			$r=Array(1.3);
			if ($active)
				$log.='<span class="yellow">你向敌人扔出了一颗电磁干扰弹！</span><br>';
			else  $log.='<span class="yellow">敌人向你扔出了一颗电磁干扰弹！</span><br>';
		}
		return array_merge($r,$chprocess($pa, $pd, $active));
	}
	
	function strike_finish(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if ($pa['bskill']==237)
		{
			eval(import_module('logger','skill601','sys'));
			if (!\skillbase\skill_query(601,$pd)){
				\skillbase\skill_acquire(601,$pd);
				$var_237=$now;
			}else{
				$var_237=\skillbase\skill_getvalue(601,'end',$pd);
				if ($var_237<$now) $var_237=$now;
			}
			\skillbase\skill_setvalue(601,'start',$var_237,$pd);
			\skillbase\skill_setvalue(601,'end',$var_237+40,$pd);
		}
		$chprocess($pa,$pd,$active);
	}
	
	function parse_news($news, $hour, $min, $sec, $a, $b, $c, $d, $e)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('sys','player'));
		
		if($news == 'bskill237') 
			return "<li>{$hour}时{$min}分{$sec}秒，<span class=\"clan\">{$a}对{$b}发动了技能<span class=\"yellow\">「EMP」</span></span><br>\n";
		
		return $chprocess($news, $hour, $min, $sec, $a, $b, $c, $d, $e);
	}
	
}

?>
