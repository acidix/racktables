<?php if (defined("RS_TPL")) {?>
	<?php $this->NewSLBItemFormTop ?>
	
	<?php if ($this->is('tripletsCount')) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Manage existing (<?php $this->tripletsCount ?>)</h3>
			</div>
			<div class="box-content no-padding">
				<table class="table">
					<tbody>
						<?php $this->startLoop("allTripletsOutput"); ?>	
							<?php $this->OpFormIntro ?>
							<tr valign=top class=row_<?php $this->order ?> >
								<td rowspan=2 class=tdright valign=middle> 
									<?php $this->OpLink ?>
								</td>
								<td class=tdleft valign=bottom>
									<?php $this->entitiyCell1 ?> 
								</td>
								<td>VS config &darr;<br><textarea name=vsconfig rows=5 cols=70><?php $this->vsconfig ?> </textarea></td>
								<td class=tdleft rowspan=2 valign=middle><?php $this->ImgHref ?></td>
							</tr>
							<tr class=row_<?php $this->order ?> >
								<td class=tdleft valign=top>
									<?php $this->entitiyCell2 ?>
								</td>
								<td>
									<textarea name=rsconfig rows=5 cols=70><?php $this->rsconfig ?> </textarea><br>RS config &uarr;
									<div style='float:left; margin-top:10px'><label><input name=prio type=text size=10 value="<?php $this->prio ?> "> &larr; Priority</label></div>
								</td>
							</tr>
							</form>
						<?php $this->endLoop(); ?> 
					</tbody>
				</table>
			</div>
		</div>
	<?php } ?> 
	
	<?php $this->NewSLBItemFormBot ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>