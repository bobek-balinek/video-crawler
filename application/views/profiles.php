<?php $this->load->view('header') ?>

<!-- ADD NEW -->

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('profiles/add'); ?>
<div class="grid_16">
	<h2>Dodaj nowy profil</h2>
</div>

<div class="grid_4">
	<p>
		<label for="name">Nazwa <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="name" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="url">Adres URL <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="url" />
	</p>
</div>

<div class="grid_4">
	<p>
		<label> &nbsp;</label>
		<input type="submit" value="Dodaj" />
	</p>
</div>
<?=form_close()?>

<table id="results" class="grid_16">
	<thead>
		<th width="50%">Nazwa Profilu</th>
		<th width="50%">Adres URL</th>
		<th  colspan="2" width="10%">Opcje</th>
	</thead>
	<tbody>
	<?php if($profiles and isset($profiles)){
	foreach ( $profiles as $row ){
	?>
	<tr>
		<td><?=$row->name?></td>
		<td><?=$row->url?></td>
		<td><a href="<?=base_url()?>profiles/edit/<?=$row->id?>" class="edit">Edytuj</a></td>
		<td><a href="<?=base_url()?>profiles/delete/<?=$row->id?>" class="edit">Usuń</a></td>
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
<div class="grid_16" id="pageNavPosition"></div>

<?php $this->load->view('footer') ?>