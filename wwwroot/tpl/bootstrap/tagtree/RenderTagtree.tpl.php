<?php if (defined("RS_TPL")) {?>
<center>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Tag tree</h3>
	</div>
	<div class="box-content">
		<!--<table class=tagtree> -->
		<div class="tree-view-list" align="left"><ul>

		<?php $first = true;
			while($this->loop('Taglist')) {
				if($first) {
					$LastLvl = $this->_Level;
					$first = false;
				}
				if($LastLvl < $this->_Level) { ?>
					<ul class="jstree-open">
				<?php } else if($LastLvl > $this->_Level) { ?>
					</ul>
				<?php } ?>

			<?php if($LastLvl == $this->_Level) { ?>
				</li>
			<?php } ?>

				<li>
			<?php $this->Level; $this->Tag; ?>
			<?php if (!$this->is('Refc', '')) { ?>
				<i>(<?php $this->Refc; ?>)</i>
			<?php } ?>




		<!--	<tr class='<?php $this->Trclass ?>'> ->>
			<td align=left style='padding-left:<?php echo ($this->_Level * 16); ?>px;'>
				<?php if ($this->is('HasChildren',true)) { ?>
					<img width="16" border="0" height="16" src="?module=chrome&uri=pix/node-expanded-static.png"></img>
				<?php } ?>
				<span title="<?php $this->Stats; ?>" class="<?php $this->SpanClass; ?>">
					<?php $this->Tag; ?>
					<?php if (!$this->is('Refc', '')) { ?>
						<i>(<?php $this->Refc; ?>)</i>
					<?php } ?>
				</span>
			</td>
			</tr> -->

			<?php

				$LastLvl = $this->_Level;
			} ?>
			</li>
		</ul>
	</div>
</div>
</center>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>