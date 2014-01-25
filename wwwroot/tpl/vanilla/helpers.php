<?php
/**
 * TemplateHelper for level-2-headlines.
 * 
 * Params:
 * [0] = Content
 * @author Alexander Kastius
 *
 */
class TemplateHelperH2 extends TemplateHelperAbstract
{
	protected function generate($params)
	{
		if (count($params) == 0||$params[0]=="")
		{
			echo "";
		}
		else
		{
			echo '<h2>' . $params[0] . '</h2>';
		}
	}
}

/**
 * Template Helper that generates the default form intro. $this->getH("myhelper","ardes");
 * $this->("Form","myOperation");
 * Params:
 * [0] = Opname
 * [1] = File-Upload? (Boolean!)
 * @author Alexander
 *
 */
class TemplateHelperForm extends TemplateHelperAbstract
{
	protected function generate($params)
	{
		if (count($params) == 0||$params[0]=="")
		{
			echo "";
		}
		else 
		{
			$opname = $params[0];

			echo "<form method=post id=${opname} name=${opname} action='?module=redirect&page=${pageno}&tab=${tabno}&op=${opname}'";
			
			if (count($params)>1)
			{
				if($params[1]==true)
				{
					echo " enctype='multipart/form-data'";
					
				}
			}
			echo ">";
		}
		
	}
}

/**
*	TemplateHelper for the PrintImageHREF funktion
*
*	Params:
*	[0] = Object to Render
**/
class TemplateHelperPrintImageHref extends TemplateHelperAbstract
{
	protected function generate($params){
		if (count($params) == 0||$params[0]=="")
		{
			echo "";
		}

		$tag = $params[0];
		//Implemente HREF standard parameters
		if (count($params) < 2)
		{
			$title = "";
		}
		else
			$title = $params[1];

		if (count($params) < 3)
		{
			$do_input = FALSE;
		}
		else
			$do_input = $params[2];

		if (count($params) < 4)
		{
			$tabindex = 0;
		}
		else
			$tabindex = $params[3];

		global $image;
		if (!isset ($image[$tag]))
			$tag = 'error';
		$img = $image[$tag];
		$img['path'] = '?module=chrome&uri=' . $img['path'];

		//Loading and rendering small module in memory and returning the
		if ($do_input == TRUE){
			$tplm = TemplateManager::getInstance();
			$tplm->setTemplate("vanilla");
			
			$mod = $tplm->generateModule( "GetImageHrefDoInput", true, 
					array( "SrcPath" => $img['path'],  "TabIndex" => ($tabindex ? "tabindex=${tabindex}" : ''),
							"Title" => (!strlen ($title) ? '' : " title='${title}'") ));

			echo $mod->run();
		}
		else{
			$tplm = TemplateManager::getInstance();
			$tplm->setTemplate("vanilla");

			$mod = $tplm->generateModule("GetImageHrefNoInput", true, 
					array( "SrcPath" => $img['path'],  "ImgWidth" => $img['width'], "ImgHeight" => $img['height'] ,
							"Title" => (!strlen ($title) ? '' : " title='${title}'") ));

			echo $mod->run();
		}
	}
}

/**
*	TemplateHelper for the PrintImageHREF funktion
*
*	Params:
*	[0] = Object to Render
**/
class TemplateHelperMkA extends TemplateHelperAbstract
{
	protected function generate($params){
		if(count($params) < 2 || $params[0] == "" || $params[1] == "" ){
			echo "";
			return;
		}

		$text = $params[0];
		echo var_dump($params[0]);
		$nextpage = $params[1];

		if (count($params) < 3)
		{
			$bypass = NULL;
		}
		else
			$bypass = $params[2]; 

		if (count($params) < 4)
		{
			$nexttab = NULL;
		}
		else
			$nexttab = $params[3];

		global $page, $tab;
		if ($text == '')
			throw new InvalidArgException ('text', $text);
		if (! array_key_exists ($nextpage, $page))
			throw new InvalidArgException ('nextpage', $nextpage, 'not found');
		$args = array ('page' => $nextpage);
		if ($nexttab !== NULL)
		{
			if (! array_key_exists ($nexttab, $tab[$nextpage]))
				throw new InvalidArgException ('nexttab', $nexttab, 'not found');
			$args['tab'] = $nexttab;
		}
		if (array_key_exists ('bypass', $page[$nextpage]))
		{
			if ($bypass === NULL)
				throw new InvalidArgException ('bypass', '(NULL)');
			$args[$page[$nextpage]['bypass']] = $bypass;
		}
		echo 'Debug ' . $text;
		echo '<a href="' . makeHref ($args) . '">' . $text . '</a>';
	}
}

class TemplateHelperNiftyString extends TemplateHelperAbstract
{
	protected function generate($params)
	{
		if (count($params) == 0)
		{
			echo "";
			return;
		}
		else
		{
			$string = $params[0];
			if (count($params) >= 2)
			{
				$maxlen = $params[1];
			}
			else
			{
				$maxlen = 30;
			}
			if (count($params) >= 3)
			{
				$usetags = $params[2];
			}
			else 
			{
				$usetags = TRUE;
			}
			$cutind = '&hellip;'; // length is 1
			if (!mb_strlen ($string))
				echo '&nbsp;';
			// a tab counts for a space
			$string = preg_replace ("/\t/", ' ', $string);
			if (!$maxlen or mb_strlen ($string) <= $maxlen)
				echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
			echo
			($usetags ? ("<span title='" . htmlspecialchars ($string, ENT_QUOTES, 'UTF-8') . "'>") : '') .
			str_replace (' ', '&nbsp;', htmlspecialchars (mb_substr ($string, 0, $maxlen - 1), ENT_QUOTES, 'UTF-8')) .
			$cutind .
			($usetags ? '</span>' : '');
		}
	}
}

?>