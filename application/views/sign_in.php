<?php $this->load->view('header') ?>
<?php  if( isset($message) or !empty($message) ){ ?>
	<section class="grid_9 clearfix ">
		<?=$message['message'] ?>
	</section>
<?php } ?>
<section class="grid_9">
	<h1>Zaloguj się</h1>
	<?=form_open('sign_in') ?>
	<article class="row clearfix">
		<section class="grid_3 push_3 ">
			<label for="email">Adres email</label>
			<input type="text" name="email" value=""/><br />
			<label for="email">Haslo</label>
			<input type="password" name="password" value=""/><br />
			<input type="submit" value="Zaloguj sie" />
		</section>
		<section class="grid_3 omega">
		</section>
	</article>
	<?=form_close() ?>
</section>
<?php $this->load->view('footer') ?>