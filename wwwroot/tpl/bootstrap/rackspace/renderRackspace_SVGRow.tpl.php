<?php if (defined("RS_TPL")) {?>
 	<div class="box box-info rackbox" style="position: relative; overflow-x: auto">
		<div class="box-header" style="cursor: move;">
	        <i class="fa fa-hdd-o"></i>
	        <h3 class="box-title">Location: <?php $this->LocationName; ?>	|	Row: <?php $this->RowName; ?></h3>
	    	<div class="box-tools pull-right">
                <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
	    </div>
	    <div class="box-body" onmouseenter="showZoomNav(<?php $this->Counter; ?>);" onmouseleave="hideZoomNav(<?php $this->Counter; ?>);" style="position: relative">
		    <div class='zoom-overlay'>
			    <button class="zoom-overlay-btn zoom-in"><span class='glyphicon glyphicon-plus'></span></button></br>
			    <button class="zoom-overlay-btn reset"><span class='glyphicon glyphicon-refresh'></span></button></br>
				<button class="zoom-overlay-btn zoom-out"><span class='glyphicon glyphicon-minus'></span></button>
				<!--<input type="range" class="zoom-range"></br>-->
			</div>	
	    	<svg counter="<?php $this->Counter; ?>" width="<?php $this->OverallWidth; ?>" height="<?php $this->OverallHeight; ?>" x="<?php $this->X ?>" y="<?php $this->Y ?>">
				<a xlink:href="<?php $this->Link ?>"><text x="12" y="12" fill="black">Location: <?php $this->LocationName; ?>	|	Row: <?php $this->RowName; ?></text></a>
	 			<?php $this->Racks; ?>
	 		</svg>
	    </div>
	</div>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>