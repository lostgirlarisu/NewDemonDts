<?php

namespace skill2020
{
	//用于判定能触发该技能的武器的名字
	$weapon_name = Array('三日月宗近','大典太','鬼丸国纲','小乌丸天国','数珠丸恒次');
	
	function init() 
	{
		define('MOD_SKILL2020_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2020] = '剑舞';
	}
	
	function acquire2020(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2020(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2020(&$pa)
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

		sword_check2020($pa,$pd,$active);

		$chprocess($pa, $pd, $active);
	}
	
	function get_physical_dmg_multiplier(&$pa, &$pd, $active)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$r=Array(skill_calculate2020($pa, $pd, $active));
		return array_merge($r,$chprocess($pa,$pd,$active));
	}
	
	function skill_calculate2020(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		$skill_rate=1;
		eval(import_module('logger','skill2020'));
		//逐把剑拉出来发提示
		foreach ($pa['skill2020_flag2'] as &$wep_bag_check){
			$log .= "<span class=\"yellow\">共鸣状态中的「{$wep_bag_check}」进行了追加攻击！</span><br>";
			$skill_rate++;
	 	}
		if($skill_rate>1){
			if ($active)
				$log.="<span class=\"yellow\">「剑舞」使你造成的物理伤害提高了{$skill_rate}00%！</span><br>";
			else  $log.="<span class=\"yellow\">「剑舞」使敌人造成的物理伤害提高了{$skill_rate}0%！</span><br>";
			return $skill_rate;
		}else{
			return;	
		}
	}
	
	function sword_check2020(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('logger','skill2020'));
		$pa['skill2020_flag1']=0;//此变量确认是否已手持天下五剑当中的任意一把
		$pa['skill2020_flag2']=Array();
		//如果手持天下五剑之一就触发
		foreach ($weapon_name as &$wep_check) {
			if($pa['wep']== $wep_check && $pa['wepk']=='WK'){
		 		$pa['skill2020_flag1']=1;
		 	}
		 	for ($i = 1; $i <= 6; $i++) {
		 		//注意已经手持的不算入追加剑
		 	 	if($pa['itm'.$i]==$wep_check && $pa['itmk'.$i]=='WK' && $pa['itm'.$i]!=$pa['wep']){
		 	 		//加入数组中
		 	 		array_unshift($pa['skill2020_flag2'],$wep_check);
		 	 	}
		 	}
		}
		//删除数组中重复的值，即同名字的剑不会计算两次
		$pa['skill2020_flag2']=array_unique($pa['skill2020_flag2']);
		if($pa['skill2020_flag1'] && count($pa['skill2020_flag2'])>0){
			if ($active)
				$log.="你身边的剑因为互相共鸣而不可思议地飞舞起来！<br>";
			else  $log.="{$pa['name']}身边的剑因为互相共鸣而不可思议地飞舞起来！<br>";
		}
	}

}

?>
