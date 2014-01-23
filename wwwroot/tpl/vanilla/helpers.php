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

class TemplateHelperNiftyString extends TemplateHelperAbstract
{
	protected function generate($params)
	{
		if (count($params) == 0)
		{
			echo "";
		}
		else
		{
			$string = $params[0];
			if (count($params) >= 1)
			{
				$maxlen = $params[1];
			}
			else
			{
				$maxlen = 30;
			}
			if (count($params) >= 2)
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