<?php $this->load->view('header') ?>



<h1>Skończono skanowanie.</h1>

<?php if(isset($logs) and $logs){ ?>
<ul>
	<?php foreach ( $logs as $row ){ ?>
	<li><b class="item"><?=$row['item']?></b> / <b class="message"><?=$row['message']?></b>  </li>
	<?php } ?>
</ul>
<?php }else{ ?>

	<h4>Brak historii akcji.</h4>

<?php } ?>

<?php $this->load->view('footer') ?>