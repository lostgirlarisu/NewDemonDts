<?php

namespace skill2009
{
	$skill2009_cd=10;
	
	function init() 
	{
		define('MOD_SKILL2009_INFO','club;lock;');
		eval(import_module('clubbase'));
		$clubskillname[2009] = '创作';
	}
	
	function acquire2009(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加获得技能时的动作
		eval(import_module('sys','skill2009'));
		if ($pa['club']==201)
		{
			\skillbase\skill_setvalue(2009,'lastuse',-3000,$pa);
		}
		else
		{
			\skillbase\skill_setvalue(2009,'lastuse',$now,$pa);
		}
	}
	
	function lost2009(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加失去技能时的动作
	}
	
	function check_unlocked2009(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		//在这里添加判定技能是否已经被解锁
		return 1;
	}
	
	//return 1:技能生效中 2:技能冷却中 3:技能冷却完毕 其他:不能使用这个技能
	function check_skill2009_state(&$pa){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		if (!\skillbase\skill_query(2009, $pa) || !check_unlocked2009($pa)) return 0;
		eval(import_module('sys','player','skill2009'));
		$l=\skillbase\skill_getvalue(2009,'lastuse',$pa);
		if (($now-$l)<=$skill2009_cd) return 2;
		return 3;
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
	
	function weapon_evo2009(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player','logger','sys'));
		
		if($wepk == 'WN'){
			$log .="你没有装备武器。<br>";
			return;
		}elseif (strpos($wepsk,"w")!==false){
			$log .="你所装备的武器已经附带了<span class=\"yellow\">音波</span>属性，没有对此使用技能的必要。<br>";
			return;
		}else {
		 	$log .="你给{$wep}装载了一个音响，使之获得了<span class=\"yellow\">音波</span>属性！
		 	看起来真是太炫酷了。<br>";
		 	$wep="响奏的".$wep;
		 	$wepsk.="w";
			\skillbase\skill_setvalue(2009,'lastuse',$now);
		 	return;
		}
	}
	
	function compose2009(&$pa = NULL){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('player','logger','sys'));
		
		if(($artk == '') || ($artk == NULL)){
			$log .="你没有装备饰品。<br>";
		}elseif ($artk == 'ss') {
			$log .="你尝试为歌词卡作一首歌，显然这样不太合适。<br>";
		}else {
		 	$log .="你灵思如泉涌，为你佩戴的{$art}创作了一首歌！<br>
		 	随后你运用娴熟的手法，把{$art}潜藏的能量都注入到歌词卡里了！<br>";
		 	$art .="之歌";
			$artk ='ss';
			\skillbase\skill_setvalue(2009,'lastuse',$now);
		}
	}
	
	function act(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','player','logger','input','skill2009'));
		if(($mode=='special') && ($command=='skill2009_special')){
			
			\player\update_sdata();
			if (!\skillbase\skill_query(2009) || !check_unlocked2009($sdata))
			{
				$log.='你没有这个技能！<br>';
				$mode = 'command';
				return;
			}
			$st = check_skill2009_state($sdata);
			if ($st==0){
				$log.='你不能使用这个技能！<br>';
				$mode = 'command';
				return;
			}
			if ($st==1){
				$log.='你已经发动过这个技能了！<br>';
				$mode = 'command';
				return;
			}
			if ($st==2){
				$log.='技能冷却中！<br>';
				$mode = 'command';
				return;
			}
			
			if($subcmd=='weapon_evo2009'){
				weapon_evo2009();
				$mode = 'command';
			}elseif ($subcmd=='compose2009') {
				compose2009();
				$mode = 'command';
			}
		}
		$chprocess();
	}
	
	function get_rest_time2009(){
		//取得冷却剩余时间
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','player','logger','skill2009'));
		
		$skill2009_lst=(int)\skillbase\skill_getvalue(2009,'lastuse',$pa);
		$skill2009_rt=$skill2009_cd-($now-$skill2009_lst);
		return $skill2009_rt;
	}
}

?>
