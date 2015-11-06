<?php

namespace club201
{
	function init()
	{
		eval(import_module('clubbase'));
		$clubinfo[201] = '偶像大师';
		$clublist[201] = Array(
			'type' => 0,
			'probability' => 1000000,//为了方便测试，先写这么高
			'skills' => Array(
        10,11,
				2001,		//初始50歌魂，演唱歌词卡消耗减免
				2002,		//歌喉
				12,
				2003,2004,2005,2006,2007,
				2008,
			)
		);
	}
}

?>
