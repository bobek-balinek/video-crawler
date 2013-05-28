<?php $this->load->view('header') ?>
<?php if (isset($cookie) and $cookie) { ?>
<!-- ADD NEW -->

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('cookies/edit/'.$cookie->id); ?>
<div class="grid_16">
	<h2>Dodaj nowe ciasteczko</h2>
</div>

<div class="grid_4">
	<p>
		<label for="profile">Profil <small>Wartośc alfanumeryczna</small></label>
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

<div class="grid_6">
	<p>
		<label for="name">Nazwa <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="name" value="<?=$cookie->name?>" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="agent">Agent <small>Wartośc alfanumeryczna</small></label>
		<input type="type" name="agent" value="<?=$cookie->agent?>" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="content">Treść <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="content" value="<?=$cookie->content?>" />
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