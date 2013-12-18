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
 * Template Helper that generates the default form intro.
 * 
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
?>