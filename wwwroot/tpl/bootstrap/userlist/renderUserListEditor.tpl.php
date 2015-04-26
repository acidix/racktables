<?php if (defined("RS_TPL")) {?>
	<?php if($this->is('NewTop')) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Add new</h3>
			</div>
			<div class="box-body">
				<?php $this->getH("Form",array("createUser",false,array("class","form form-horizontal"))); ?>
				<div class='row edit_row'>
					<div class='col-sm-6 header'>
				   		<label for="username" class="control-label">Username</label>
						</div><div class="col-sm-6">
    					<input type=text size=64 name=username tabindex=100 class="form-control">
      				</div>
				</div>
				<div class='row edit_row'>
					<div class='col-sm-6 header'>
					    <label for="realname" class="control-label">Real name</label>
    			</div><div class="col-sm-6">
    						<input type=text size=64 name=realname tabindex=101 class="form-control">
      					</div>
				</div>
				<div class='row edit_row'>
					<div class='col-sm-6 header'>
					    <label for="password" class="control-label">Password</label>
    					</div><div class="col-sm-6">
    					<input type=password size=64 name=password tabindex=102 class="form-control">
      				</div>
				</div>
				<div class='row edit_row'>
					<div class='col-sm-6 header'>
					    <label class="control-label">Tags</label>
    					</div><div class="col-sm-6">
								<?php $this->TagsPicker; ?>
  					</div>
				</div>
				<div class='row edit_row'>
    				<div class="col-sm-offset-6 col-sm-6" style="text-align: center;">
     					<button type="submit" class="btn btn-primary">Submit</button>
    				</div>
  				</div>
  				</form>
			</div>
		</div>

	<?php } ?>
	<div class="box">
	<div class="box-header">
		<h3 class="box-title">Manage existing (<?php $this->Count; ?>)</h3>
	</div>
	<div class="box-body">
		<table class="table table-striped">
			<thead>
				<tr><th>Username</th><th>Real name</th><th>Password</th><th>&nbsp;</th></tr>
			</thead>
			<tbody>
				<?php while($this->loop('Users')) { ?>
				<tr>
					<?php $this->getH("Form","updateUser"); ?>
					<input type=hidden name="user_id" value="<?php $this->UserId; ?>">
					<td style="vertical-align: middle;">
						<input type=text name=username value='<?php $this->Name; ?>' size=16>
					</td>
					<td style="vertical-align: middle;">
						<input type=text name=realname value='<?php $this->RealName; ?>' size=24>
					</td>
					<td style="vertical-align: middle;">
						<input type=password name=password size=40>
					</td>
					<td style="vertical-align: middle;">
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
					</td>
					</form>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	</div>
	<?php if(!$this->is('NewTop')) { ?>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Add new</h3>
			</div>
			<div class="box-body">
				<?php $this->getH("Form",array("createUser",false,array("class","form form-horizontal"))); ?>
				<div class="form-group">
					    <label for="username" class="col-md-3 control-label">Username</label>
    					<div class="col-md-9">
    						<input type=text size=64 name=username tabindex=100 class="form-control">
      					</div>
				</div>
				<div class="form-group">
					    <label for="realname" class="col-md-3 control-label">Real name</label>
    					<div class="col-md-9">
    						<input type=text size=64 name=realname tabindex=101 class="form-control">
      					</div>
				</div>
				<div class="form-group">
					    <label for="password" class="col-md-3 control-label">Password</label>
    					<div class="col-md-9">
    						<input type=password size=64 name=password tabindex=102 class="form-control">
      					</div>
				</div>
				<div class="form-group">
					    <label class="col-md-3 control-label">Tags</label>
    					<div class="col-md-9">
    						<?php $this->TagsPicker; ?>
      					</div>
				</div>
				<div class="form-group">
    				<div class="col-sm-offset-2 col-sm-10">
     					<button type="submit" class="btn btn-primary">Submit</button>
    				</div>
  				</div>
  				</form>
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
Don't use this page directly, it's supposed <br />
to get loaded within the main page. <br />
Return to the index. <br />
<?php }?>
