<?php $this->load->view('header') ?>

<h1>Uruchom bot'a</h1>
<?=form_open('crawler'); ?>


<div class="grid_4 alpha">
	<p>
		<label for="mode">Wybierz tryb <small></small></label>
		<select name="mode" id="mode">
			<option value="profiles">Zbierz filmy</option>
			<option value="url">Zbierz adresy URL</option>
		</select>
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="profile">Wybierz profil do skanowania <small></small></label>
		<?php if($profiles){ ?>
		<select name="profile" id="profile">
			<?php foreach($profiles as $row){ ?>
			<option value="<?=$row->id?>" <?php if($row->idProfiles = $row->id){ echo 'selected'; }?> ><?=$row->name?></option>
			<?php } ?>
		</select>
		<?php }else{ ?>
			<b>Brak profili.</b>
		<?php } ?>
	</p>
</div>

<div class="grid_4">
	<p>
		<label> &nbsp;</label>
		<input type="submit" value="URUCHOM" />
	</p>
</div>

<?=form_close(); ?>
<?php $this->load->view('footer') ?>