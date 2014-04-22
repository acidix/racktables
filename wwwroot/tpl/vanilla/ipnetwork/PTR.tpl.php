<?php if (defined("RS_TPL")) {
	$this->addJS('js/racktables.js'); ?>
	<center><h1><?php $this->IP; ?>/<?php $this->Mask; ?></h1><h2><?php $this->Name; ?></h2></center>
	<table class=objview border=0 width='100%'><tr><td class=pcleft>
	<tr>
		<td class=pcleft>
			<div class=portlet>
				<h2>current records</h2>#
				<center>
					<?php if($this->is('Paged')) { ?>
						<h3><?php $this->StartIP; ?> ~ <?php $this->EndIP; ?></h3>
					<?php } ?>
					<?php $this->startLoop('Pages'); ?>
						<?php $this->B; ?><a href='<?php $this->Link(); ?>'>$i</a><?php $this->BEnd; ?>
					<?php $this->endLoop(); ?>	
				</center>
				<?php $this->getH('PrintOpFormIntro',array('importPTRData', array ('addrcount' => $this->_AddrCount))); ?>
				<table class='widetable' border=0 cellspacing=0 cellpadding=5 align='center'>
				<tr><th>address</th><th>current name</th><th>DNS data</th><th>import</th></tr>
					<?php $this->IPList; ?>
				<tr>
					<td colspan=3 align=center><input type=submit value='Import selected records'></td>
					<td>
						<?php if ($this->is('BoxCounter')) { ?>
							<a href='javascript:;' onclick="toggleColumnOfAtoms(1, 1, <?php $this->BoxCounter; ?>)">(toggle selection)</a>
						<?php } else { ?>&nbsp;<?php } ?>
					</td>
				</tr>
				</table>
				</form>
			</div>
		</td>
		<td class=pcright>
			<div class=portlet>
				<h2>stats</h2>
				<table border=0 width='100%' cellspacing=0 cellpadding=2>
					<tr class=trok><th class=tdright>Exact matches:</th><td class=tdleft><?php $this->Matches; ?></td></tr>
					<tr class=trwarning><th class=tdright>Missing from DB/DNS:</th><td class=tdleft><?php $this->Missing; ?></td></tr>
					<?php if($this->is('Mismatch')) { ?>
						<tr class=trerror><th class=tdright>Mismatches:</th><td class=tdleft><?php $this->MisMatch; ?></td></tr>
					<?php } ?>
				</table>
			</div>
		</td>
	</tr>
	</table>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>