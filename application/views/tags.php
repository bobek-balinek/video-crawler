<?php $this->load->view('header') ?>

<!-- ADD NEW -->

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('tags/add'); ?>
<div class="grid_16">
	<h2>Dodaj nowy tag</h2>
</div>

<div class="grid_4">
	<p>
		<label for="profile">Profil <small>Wartośc alfanumeryczna</small></label>
		<?php if($profiles){ ?>
		<select name="profile" id="profile">
			<?php foreach($profiles as $row){ ?>
			<option value="<?=$row->id?>"><?=$row->name?></option>
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
		<input type="text" name="text" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="type">Typ </label>
		<select name="type" id="type">
			<option value="url">Adres URL</option>
			<option value="video">Wideo</option>
			<option value="desc">Opis</option>
			<option value="title">Tytuł</option>
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

<table class="grid_16">
	<thead>
		<th width="20%">Nazwa Profilu</th>
		<th width="40%">Text</th>
		<th width="40%">Typ</th>
		<th  colspan="2" width="10%">Opcje</th>
	</thead>
	<tbody>
	<?php if($tags and isset($tags)){ 
		foreach($tags as $row){
	?>
	<tr>
		<td><?=$row->profile_name?></td>
		<td><?=$row->text?></td>
		<td><?=$row->type?></td>
		<td><a href="<?=base_url()?>tags/edit/<?=$row->id?>" class="edit">Edytuj</a></td>
		<td><a href="<?=base_url()?>tags/delete/<?=$row->id?>" class="edit">Usuń</a></td>
	</tr>
	<?php } }else{ ?>
		<td>Brak profili</td>
		<td></td>
		<td></td>
		<td></td>
	<?php
	}?>
	</tbody>
</table>

<?php $this->load->view('footer') ?>