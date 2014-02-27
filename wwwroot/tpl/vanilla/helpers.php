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
		global $pageno, $tabno;
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

class TemplateHelperSerializeTags extends TemplateHelperAbstract

{
	protected function generate($params)
	{
		//($chain, $baseurl = '')
		//Initalize paramters 
		if(count($params) < 1)
			return "";
		$chain = $params[0];
		$baseurl = '';

		if(count($params) > 1)
			$baseurl = $params[1];

		$tmp = array();
		usort ($chain, 'cmpTags');
		foreach ($chain as $taginfo)
		{
			$title = '';
			if (isset ($taginfo['user']) and isset ($taginfo['time']))
				$title = 'title="' . htmlspecialchars ($taginfo['user'] . ', ' . formatAge ($taginfo['time']), ENT_QUOTES) . '"';

			$class = '';
			if (isset ($taginfo['id']))
				$class = 'class="' . getTagClassName ($taginfo['id']) . '"';

			$href = '';
			if ($baseurl == '')
				$tag = 'span';
			else
			{
				$tag = 'a';
				$href = "href='${baseurl}cft[]=${taginfo['id']}'";
			}
			$tmp[] = "<$tag $href $title $class>" . $taginfo['tag'] . "</$tag>";
		}
		return implode (', ', $tmp);
	}
}

class TemplateHelperPrintTagTRs extends TemplateHelperAbstract
{
	protected function generate($params)
	{
		//($chain, $baseurl = '')
		//Initalize paramters 
		if(count($params) < 1)
			return "";
		
		$chain = $params[0];
		$baseurl = '';

		if(count($params) > 1)
			$baseurl = $params[1];

		if (getConfigVar ('SHOW_EXPLICIT_TAGS') == 'yes' and count ($cell['etags']))
		{
			echo "<tr><th width='50%' class=tagchain>Explicit tags:</th><td class=tagchain>";
			echo serializeTags ($cell['etags'], $baseurl) . "</td></tr>\n";
		}
		if (getConfigVar ('SHOW_IMPLICIT_TAGS') == 'yes' and count ($cell['itags']))
		{
			echo "<tr><th width='50%' class=tagchain>Implicit tags:</th><td class=tagchain>";
			echo serializeTags ($cell['itags'], $baseurl) . "</td></tr>\n";
		}
		if (getConfigVar ('SHOW_AUTOMATIC_TAGS') == 'yes' and count ($cell['atags']))
		{
			echo "<tr><th width='50%' class=tagchain>Automatic tags:</th><td class=tagchain>";
			echo serializeTags ($cell['atags']) . "</td></tr>\n";
		}
	}
}

class TemplateHelperPrintOpFormIntro extends TemplateHelperAbstract
{
	protected function generate($params){
		//Initalise standard parameters
		if(count($params) < 1)
			return "";
		$opname = $params[0];
		$extra = array();
		$upload = FALSE;

		if(count($params) > 1)
			$extra = $params[1];
		if(count($params) > 2)
			$upload = $params[2];

		global $pageno, $tabno, $page;
		$tplm = TemplateManager::getInstance();
		$tplm->setTemplate("vanilla");
		
		$mod = $tplm->generateModule("PrintOpFormIntro",  false, array("opname" => $opname, "pageno" => $pageno, "tabno" => $tabno));

	//	echo "<form method=post id=${opname} name=${opname} action='?module=redirect&page=${pageno}&tab=${tabno}&op=${opname}'";
		if ($upload)
			$mod->setOutput("isUpload", true);	 
	//		echo " enctype='multipart/form-data'";

	//	echo ">";
		fillBypassValues ($pageno, $extra);
		$loopArray = array();
		foreach ($extra as $inputname => $inputvalue)
			$loopArray[] = array("name" => htmlspecialchars ($inputname, ENT_QUOTES), "val" => htmlspecialchars ($inputvalue, ENT_QUOTES));
	//		printf ('<input type=hidden name="%s" value="%s">', htmlspecialchars ($inputname, ENT_QUOTES), htmlspecialchars ($inputvalue, ENT_QUOTES));
		$mod->setOutput("loopArray", $loopArray);
		$mod->run();
	}

}

class TemplateHelperGetOpLink extends TemplateHelperAbstract
{
	protected function generate($params){
	//	($params, $title,  $img_name = '', $comment = '', $class = '')	
		//Initalise standard parameters
		if(count($params) < 2)
			return "";
		$stdparams = $params[0];
		$title = $params[1];
		$img_name = '';
		$comment = '';
		$class = '';

		if(count($params) > 2)
			$img_name = $params[2];
		if(count($params) > 3)
			$comment = $params[3];
		if(count($params) > 4)
			$class = $params[4];

		//Initiate TemplateManager
		$tplm = TemplateManager::getInstance();
		$tplm->setTemplate("vanilla");
		$mod = $tplm->generateModule("GetOpLink", false);
		
		if (isset ($stdparams)){
			$mod->setOutput("issetParams", true);
			$mod->setOutput("href", makeHrefProcess ($stdparams));
	//		$ret = '<a href="' . makeHrefProcess ($params) . '"';
		}
		else
		{
	//		$ret = '<a href="#" onclick="return false;"';
			$class .= ' noclick';
		}

		if (! empty ($comment)){
			$mod->setOutput("showComment", true);
			$mod->setOutput("htmlComment", htmlspecialchars ($comment, ENT_QUOTES));	
		}
	//		$ret .= ' title="' . htmlspecialchars ($comment, ENT_QUOTES) . '"';
		$class = trim ($class);
		
		if (! empty ($class)){
			$mod->setOutput("showClass", true);
			$mod->setOutput("htmlClass", htmlspecialchars ($class, ENT_QUOTES));		 
		}
	//		$ret .= ' class="' . htmlspecialchars ($class, ENT_QUOTES) . '"';
	//	if (! empty ($comment))
	//		$ret .= 'title="' . htmlspecialchars($comment, ENT_QUOTES) . '"';
	//	$ret .= '>';
		if (! empty ($img_name))
		{
			$mod->setOutput("loadImage", true);
			$mod->setOutput("imgName", $imgName);
			$mod->setOutput("comment", $comment);			 
	//		$ret .= getImageHREF ($img_name, $comment);
	//		if (! empty ($title))
	//			$ret .= ' ';
		}
		if (FALSE !== strpos ($class, 'need-confirmation'))
			$mod->setOutput("loadJs", true);			 
	//		addJS ('js/racktables.js');
		$mod->setOutput("title", $title);
	//	$ret .= $title . '</a>';
	//	return $ret;
		return $mod->run();
	}
} 

class TemplateHelperTplSelect extends TemplateHelperAbstract
{
	protected function generate($params){
		$code = '<select name="template">';
		$list = TemplateManager::getOrderedTemplateList();
		foreach ($list as $template) {
			$code .= '<option>' . $template . '</option>';
		}
		$code .= '</select>';
		echo $code;
	}	
}
?>