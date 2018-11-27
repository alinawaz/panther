<?php use System\Libs\Lang; use System\Libs\URL; ?><h1>Welcome to sleek rendering engine</h1>
<p> Let's see how php tags work, <?php echo  "I am echoed from php" ; ?> </p>
<p> I am variable $test from entity with value = <?php echo  $test ; ?> </p>

<?php if($test == '123'){ ?>
	<p>It's One Two Three!</p>
<?php } ?> 

<ul>
<?php foreach($items as $item){ ?>
	<li><?php echo  $item; ?></li>
<?php } ?>
</ul>