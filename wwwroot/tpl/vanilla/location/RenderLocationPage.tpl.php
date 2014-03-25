<?php if (defined("RS_TPL")) {?>

	<table border=0 class=objectview cellspacing=0 cellpadding=0><tr>
	<!--  left collum with information  -->
	<td class=pcleft>
	<?php 
		$this->Renderentitysummary;
		$this->Renderfilesportlet;
	?>
	</td>	
   <!-- Right column with list of rows and child locations -->

   <td class=pcright>


   <div class=portlet><h2>Rows (<?php $this->Count; ?>)</h2>

   	<table border=0 cellspacing=0 cellpadding=5 align=center>

   		<?php 
   			$this->startLoop('Looparray');
   		?> 
   			<tr><td>
   				<?php $this->mKa; ?>
   			</td></tr>	

   		<?php 
   			$this->endLoop();
   		 ?>

   		 </table></div>

   		    <div class=portlet><h2>Child Locations (<?php $this->Countlocations; ?>)</h2>

   		    	<table border=0 cellspacing=0 cellpadding=5 align=center>

   		    	<?php 
   		    		$this->startLoop('Looparray2');
   		    	?>
   		    		<tr><td>
   		    	<?php $this->Locationmka; ?>	
   		    		</td></tr>
   		    	<?php 
   		    		$this->endLoop();
   		    	?>	

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