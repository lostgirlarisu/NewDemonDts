<?php

namespace skill2013
{
	//发动几率
	$skillrate=30;
	
	function init() 
	{
		define('MOD_SKILL2013_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2013] = '破甲点射';
	}
	
	function acquire2013(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
	}
	
	function lost2013(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2013(&$pa)
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
		if(\skillbase\skill_query(2013,$pa) && check_unlocked2013($pa)){
			equip_break2013($pa,$pd,$active);
		}
		$chprocess($pa, $pd, $active);
	}
	
	function equip_break2013(&$pa, &$pd, $active){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('skill2013','logger','wound'));

		$event_dice=rand(1,100);
		if($event_dice <= $skillrate){
			$log .= "<span class=\"yellow\">甲斐凭借着丰富的经验预判了你的行动，并且准确无误地对你的手脚以及穿戴的装备进行器械磨损性攻击！</span><br>";
			$damage=rand(5,40);
			equip_break_detail2013($pd,'wep',$damage);
			equip_break_detail2013($pd,'ara',$damage);
			equip_break_detail2013($pd,'arf',$damage);
			equip_break_detail2013($pd,'art',$damage);
			\wound\get_inf(a,$pd);
			\wound\get_inf(f,$pd);
			$log .= "致伤攻击使你的<span class=\"red\">腕部</span>和<span class=\"red\">足部</span>受伤了！<br>";
		}
	}
	
	function equip_break_detail2013(&$pa,$tag = NULL,$damage){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//对部位破坏的细节内容，便于任何部位通用
		eval(import_module('logger'));
		if ($tag == NULL || $tag == '') return;
		
		if(($pa[$tag.'s'] !=0)&&($pa[$tag.'s'] !=$nosta)){
			$pa[$tag.'s']-=$damage;
			$log .= "攻击使得<span class=\"red\">{$pa[$tag]}</span>的耐久度下降了<span class=\"red\">{$damage}</span>点！<br>";
			item_check2013($pa,$tag);
		}
	}
	
	function item_check2013(&$pa,$tag = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//为了判断装备有没有损坏而特地写的函数
		eval(import_module('logger'));
		if ($tag == NULL || $tag == '') return;
		
		if($pa[$tag.'s'] <= 0){
			$log .= "<span class=\"red\">{$pa[$tag]}</span>被彻底破坏了！<br>";
			$pa[$tag] = $pa[$tag.'k'] = $pa[$tag.'sk'] ='';
			$pa[$tag.'e'] = $pa[$tag.'s'] =0;
		}
	}
}

?>
