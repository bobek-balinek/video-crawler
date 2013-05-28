<?php $this->load->view('header') ?>

<?php if($profile and isset($profile)){ ?>

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('profiles/edit/'.$this->uri->segment(3)); ?>
<div class="grid_16">
	<h2>Dodaj nowy profil</h2>
</div>

<div class="grid_4">
	<p>
		<label for="name">Nazwa <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="name" value="<?=$profile->name?>" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="url">Adres URL <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="url" value="<?=$profile->url ?>" />
	</p>
</div>

<div class="grid_4">
	<p>
		<label> &nbsp;</label>
		<input type="submit" value="Zapisz" />
	</p>
</div>
<?=form_close()?>

<?php } ?>

<?php $this->load->view('footer') ?>