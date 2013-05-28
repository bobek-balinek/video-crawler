<?=$this->load->view('header',true) ?>

		<!-- FORM -->
		<?php if(isset($message)){ echo $message; } ?>
		
		<div class="grid_16">
			<h2>Czy napewno chcesz usunąć dany element?</h2>
		</div>
		
		<p>Pamiętaj! Raz usunięty element nie będzie mógł być przywrócony.</p>
		
		<div class="grid_5">
			<p>
				<a href="<?=base_url().$this->uri->uri_string()?>/confirmed">Tak</a>
			</p>
		</div>
		
		<div class="grid_5">
			<p>
				<a href="<?=base_url().$this->uri->segment(1)?>">Nie</a>
			</p>
		</div>
		
		

<?=$this->load->view('footer',true) ?>