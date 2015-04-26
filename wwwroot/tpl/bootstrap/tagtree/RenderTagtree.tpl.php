<?php if (defined("RS_TPL")) {?>
<center>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Tag tree</h3>
	</div>
	<div class="box-content">
		<!--<table class=tagtree> -->
		<div class="tree-view-list" align="left" style="padding-left: 10em">
		<ul style="list-style-type: none;">
			<?php $first = true;
			while($this->loop('Taglist')) {
				if($first) {
					$LastLvl = $this->_Level;
					$first = false;
				}
				if($LastLvl < $this->_Level) { ?>
					<!-- open new sub tree -->
					<div style="right: 2em; color: #3c8dbc; margin-right: -1em; top: 0.5em" class="pull-left glyphicon glyphicon-chevron-down"></div>
					<ul style="list-style-type: none;">
				<?php } else if($LastLvl > $this->_Level) { ?>
					</ul>
				<?php } ?>

			<?php if($LastLvl == $this->_Level) { ?>
				</li>
			<?php } ?>

				<li>
					<div class="tag_small">
						<span><?php $this->Tag; ?></span>
					</div>
					<?php if (!$this->is('Refc', '')) { ?>
						<i>(<?php $this->Refc; ?>)</i>
					<?php } ?>
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
