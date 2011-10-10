<?php $this->load->view('header') ?>

<!-- ADD NEW -->

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('urls/add'); ?>
<div class="grid_16">
	<h2>Dodaj nowy adres url</h2>
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
		<label for="url">Adres URL <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="url" />
	</p>
</div>


<div class="grid_6">
	<p>
		<label for="text">Tekst <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="text" />
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
		<th width="40%">Adres URL</th>
		<th width="40%">Text</th>
		<th  colspan="2" width="10%">Opcje</th>
	</thead>
	<tbody>
	<?php if($urls and isset($urls)){ 
		foreach($urls as $row){
	?>
	<tr>
		<td><?=$row->profile_name?></td>
		<td><?=$row->url?></td>
		<td><?=$row->text?></td>
		<td><a href="<?=base_url()?>urls/edit/<?=$row->id?>" class="edit">Edytuj</a></td>
		<td><a href="<?=base_url()?>urls/delete/<?=$row->id?>" class="edit">Usuń</a></td>
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