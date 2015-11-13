<?php

namespace skill230
{
	function init() 
	{
		define('MOD_SKILL230_INFO','club;active;hidden;');
	}
	
	function acquire230(&$pa)
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
	}
	
	function lost230(&$pa)
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
		
	
	function wele(){
		if (eval(__MAGIC__)) return $___RET_VALUE;
		eval(import_module('sys','player','itemmain','logger'));
		if($wepk == 'WN' || !$wepe || !$weps){
			$log .= '<span class="red">你没有装备武器，无法改造！</span><br />';
			$mode = 'command';
			return;
		}
		if (strpos($wepsk,'j')!==false){
			$log.='多重武器不能改造。<br>';
			$mode='command';
			return;
		}
		if(\skillbase\skill_query(230)){
			$position = 0;
			foreach(Array(1,2,3,4,5,6) as $imn){
				global ${'itm'.$imn},${'itmk'.$imn},${'itme'.$imn},${'itms'.$imn},${'itmsk'.$imn};
				if(strpos(${'itmk'.$imn},'B')===0 && ${'itme'.$imn} > 0 ){
					$position = $imn;
					break;
				}
			}
			if($position){
				if(strpos($wepsk,'e')!==false){
					$log .= '<span class="red">武器已经带电，不用改造！</span><br />';
					$mode = 'command';
					return;
				}elseif(strlen($wepsk)>=5){
					$log .= '<span class="red">武器属性数目达到上限，无法改造！</span><br />';
					$mode = 'command';
					return;
				}
				${'itms'.$position}-=1;
				$itm = ${'itm'.$position};
				$log .= "<span class=\"yellow\">用{$itm}改造了{$wep}，{$wep}增加了电击属性！</span><br />";
				$wep = '电气'.$wep;
				$wepsk .= 'e';
				if(${'itms'.$position} == 0){
					$log .= "<span class=\"red\">$itm</span>用光了。<br />";
					${'itm'.$position} = ${'itmk'.$position} = ${'itmsk'.$position} = '';
					${'itme'.$position} =${'itms'.$position} =0;				
				}
				$mode = 'command';
				return;
			}else{
				$log .= '<span class="red">你没有电池，无法改造武器！</span><br />';
				$mode = 'command';
				return;
			}
		}else{
			$log .= '<span class="red">你没有这个技能！</span><br />';
			$mode = 'command';
			return;
		}
	}
	
	function act()
	{
		if (eval(__MAGIC__)) return $___RET_VALUE;
		
		eval(import_module('sys','player','logger','input'));
	

		if ($mode == 'special' && $command == 'skill230_special' && $subcmd=='wele') 
		{
			wele();
			return;
		}
			
		$chprocess();
	}
	
}

?>
