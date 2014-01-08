<?php if (defined("RS_TPL")) {?>
			<?php $this->addRequirement("Header","HeaderJsInline",array("code"=>"tag_cb.enableSubmitOnClick()")); ?>
			<tr class='<?php $this->get("TrClass"); ?>'>
				<td class='<?php $this->get("TdClass"); ?>' style='padding-left: <?php $this->get("LevelPx"); ?>px;'>
					<label>
						<input type=checkbox class='<?php $this->get("InputClass"); ?>' name='<?php $this->get("InputName"); ?>[]' value='<?php $this->get("InputValue"); ?>' <?php $this->get("ExtraAttrs"); ?>>
						<span class="<?php $this->get("TagClass"); ?>"> <?php $this->get("TagName"); ?></span>
						<?php $this->get("RefCnt"); ?>
					</label>
				</td>
			</tr>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>