<?php $this->load->view('header') ?>

<?php if($url and isset($url)) { ?>

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('urls/edit/'.$this->uri->segment(3)); ?>
<div class="grid_16">
	<h2>Dodaj nowy adres url</h2>
</div>

<div class="grid_4">
	<p>
		<label for="profile">Profil <small>Wartośc alfanumeryczna</small></label>
		<?php if($profiles){ ?>
		<select name="profile" id="profile">
			<?php foreach($profiles as $row){ ?>
			<option value="<?=$row->id?>" <?php if($url->idProfiles = $row->id){ echo 'selected'; }?> ><?=$row->name?></option>
			<?php } ?>
		</select>
		<?php }else{ ?>
			<b>Brak profili.</b>
		<?php } ?>
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="url">Adres URL <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="url" value="<?=$url->url ?>" />
	</p>
</div>


<div class="grid_6">
	<p>
		<label for="text">Tekst <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="text" value="<?=$url->text ?>" />
	</p>
</div>

<div class="grid_4">
	<p>
		<label> &nbsp;</label>
		<input type="submit" value="Dodaj" />
	</p>
</div>
<?=form_close()?>

<?php } ?>

<?php $this->load->view('footer') ?>