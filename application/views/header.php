<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Panel Administratora - Wesela-podhale.pl</title>
		<link rel="stylesheet" href="<?=base_url()?>css/960/960.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?=base_url()?>css/960/text.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?=base_url()?>css/template.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?=base_url()?>css/colour.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="<?=base_url()?>js/paging.js"></script>
	</head>
	<body>

		<h1 id="head">Panel Administratora 
			<?php if( isset($userdata) and $userdata ){ ?><span class="user">Zalogowany jako: <?=$userdata->name ?> <a href="<?=base_url() ?>admin/wyloguj">Wyloguj</a></span><?php } ?></h1>
		
		<ul id="navigation">
			<li><a href="<?=base_url()?>">Podgląd</a></li>
			<li><a href="<?=base_url()?>profiles">Profile</a></li>
			<li><a href="<?=base_url()?>urls">Adresy URL</a></li>
			<li><a href="<?=base_url()?>tags">Tagi</a></li>
			<li><a href="<?=base_url()?>cookies">Ciasteczka</a></li>
			<li><a href="<?=base_url()?>settings">Ustawienia</a></li>
			<li><a href="<?=base_url()?>crawler">Uruchom</a></li>
		</ul>

		<div id="content" class="container_16 clearfix">