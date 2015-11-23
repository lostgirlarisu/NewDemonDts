<?php

namespace skill2014
{
	//发动几率
	$skillrate=30;
	//成功率
	$changerate=30;
	
	function init() 
	{
		define('MOD_SKILL2014_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2014] = '构成破坏';
	}
	
	function acquire2014(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2014(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2014(&$pa)
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
		if(\skillbase\skill_query(2014,$pa) && check_unlocked2014($pa)){
			body_break2014($pa,$pd,$active);
		}
		$chprocess($pa, $pd, $active);
	}
	
	function body_break2014(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2014','logger'));
		
		$event_dice=rand(1,100);
		if($event_dice <=$skillrate){
			$log .= "<span class=\"yellow\">“解构分析完成！来尝尝本小姐的最新研究成果！”條原的某种指令启动了周围隐藏的科技武器！</span><br>";
			$log .= "<span class=\"yellow\">你被不可思议的射线照射了！！</span><br>";
			$event_dice2=rand(1,100);
			if($event_dice2 <= $changerate){
				$pd['mhp'] = $pd['hp'];
				$log .= "科学射线影响了你的<span class=\"red\">生命上限</span>！<br>";
			}else{
				$log .= "科学射线似乎对你没有什么影响。<br>";
				$log .= "“诶诶诶！哪里弄错了吗？！讨厌！！”<br>";
			}
		}
	}
}

?>
