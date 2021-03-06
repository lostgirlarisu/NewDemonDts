<?php

namespace skill2000
{
	function init() 
	{
		define('MOD_SKILL2000_INFO','club;lock;upgrade;');
		eval(import_module('clubbase'));
		$clubskillname[2000] = '调试';
	}
	
	function acquire2000(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		\skillbase\skill_setvalue(2000,'choice','1',$pa);
		\skillbase\skill_setvalue(2000,'choice2','1',$pa);
	}
	
	function lost2000(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
		\skillbase\skill_delvalue(2000,'choice',$pa);
		\skillbase\skill_delvalue(2000,'choice2',$pa);
	}
	
	function check_unlocked2000(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return 1;
	}
	
	function upgrade2000()
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player','logger','skill2000','input'));
		if (!\skillbase\skill_query(2000) || !check_unlocked2000($sdata))
		{
			$log .= '你没有这个技能。<br>';
			return;
		}
		if($skillpara1){
			$val = \skillbase\skill_getvalue(2000,'choice');
			if ($val==0){$val=1;}
			elseif ($val==1) {$val=0;}
			\skillbase\skill_setvalue(2000,'choice',$val);
			$skillpara1=0;
		}
		if($skillpara2){
			$val = \skillbase\skill_getvalue(2000,'choice2');
			if ($val==0){$val=1;}
			elseif ($val==1) {$val=0;}
			\skillbase\skill_setvalue(2000,'choice2',$val);
			$skillpara2=0;
		}
		//test2000($pa);
		$log.='设置成功。<br>';
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
	
	function calculate_meetman_rate_by_mode($schmode)
	{
		//控制遇敌率
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$choice = \skillbase\skill_getvalue(2000,'choice',$pd);
		if($choice==0){$r = 0;}
		else{$r = 99999;}

		return $chprocess($schmode) + $r;
	}

	function calculate_active_obbs(&$ldata,&$edata)
	{
		//控制先攻率
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','pose'));
		
		$choice2 = \skillbase\skill_getvalue(2000,'choice2',$pd);
		if($choice2==0){$r = 0;}
		else{$r = 99999;}
		
		return $chprocess($ldata,$edata)+$r;
	}
/*
	function test2000(&$pa){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player','logger'));
		$log.= "目前变量pa是<br>".json_encode($pa)."<br>";
		return;
	}
*/
}

?>
