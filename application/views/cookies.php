<?php $this->load->view('header') ?>

<!-- ADD NEW -->

<?php if(isset($message)){ echo $message; } ?>
<?=form_open('cookies/add'); ?>
<div class="grid_16">
	<h2>Dodaj nowe ciasteczko</h2>
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
		<label for="name">Nazwa <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="name" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="agent">Agent <small>Wartośc alfanumeryczna</small></label>
		<input type="type" name="agent" />
	</p>
</div>

<div class="grid_6">
	<p>
		<label for="content">Treść <small>Wartośc alfanumeryczna</small></label>
		<input type="text" name="content" />
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
		<th width="20%">Nazwa Profilu</th>
		<th width="30%">Nazwa</th>
		<th width="30%">Agent</th>
		<th width="30%">Treść</th>
		<th  colspan="2" width="10%">Opcje</th>
	</thead>
	<tbody>
	<?php if($cookies and isset($cookies)){
		foreach($cookies as $row){
	?>
	<tr>
		<td><?=$row->profile_name?></td>
		<td><?=$row->name?></td>
		<td><?=$row->agent?></td>
		<td><?=$row->content?></td>
		<td><a href="<?=base_url()?>cookies/edit/<?=$row->id?>" class="edit">Edytuj</a></td>
		<td><a href="<?=base_url()?>cookies/delete/<?=$row->id?>" class="edit">Usuń</a></td>
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