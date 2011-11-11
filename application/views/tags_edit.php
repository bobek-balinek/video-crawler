<?php $this->load->view('header') ?>

<!-- ADD NEW -->
<?php if($tag and isset($tag)){ ?>

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('tags/edit/'.$this->uri->segment(3)); ?>
<div class="grid_16">
	<h2>Dodaj nowy tag</h2>
</div>

<div class="grid_4">
	<p>
		<label for="profile">Profil <small>Wartośc alfanumeryczna</small></label>
		<?php if($profiles){ ?>
		<select name="profile" id="profile">
			<?php foreach($profiles as $row){ ?>
			<option value="<?=$row->id?>" <?php if($tag->idProfiles = $row->id){ echo 'selected'; }?> ><?=$row->name?></option>
			<?php } ?>
		</select>
		<?php }else{ ?>
			<b>Brak profili.</b>
		<?php } ?>
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="text">Tekst <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="text" value="<?=htmlspecialchars($tag->text) ?>" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="type">Typ </label>
		<select name="type" id="type">
			<option value="url" <?php if($tag->type=='url') echo 'selected' ?>>Adres URL</option>
			<option value="video" <?php if($tag->type=='video') echo 'selected' ?>>Wideo</option>
			<option value="desc"<?php if($tag->type=='desc') echo 'selected' ?> >Opis</option>
			<option value="img"<?php if($tag->type=='img') echo 'selected' ?> >Obraz</option>
			<option value="title"<?php if($tag->type=='title') echo 'selected' ?> >Tytuł</option>
		</select>
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