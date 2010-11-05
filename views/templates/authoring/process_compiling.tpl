<div>
	
	<h1><img src="<?=BASE_WWW?>img/compile.png" />&nbsp;&nbsp;<?=__('Compilation of the delivery')?> <?=get_data('processLabel')?></h1>
	
	<br/>
	<br/>
	<p><?=__('A delivery must to be compiled before being executed. The compilation can be done here.')?><br/>
	<?=__('A recompilation is also required after modification on the tests composing a delivery.')?></p>
	
	<p><img src="<?=BASE_WWW?>img/dialog-warning.png"/>&nbsp;<?=__('Note: please make sure that all tests that make up the delivery are well defined and set to "active" in the test extension before compiling the delivery.')?></p>
	<br/>
	
	<?if(get_data('isCompiled')):?>
		<p><img src="<?=BASE_WWW?>img/info.png"/>&nbsp;<?=__('The delivery was last compiled on')?> <span id="compiledDate"><?=get_data('compiledDate')?></span>.</p>
	<?endif;?>
	
	<a href="#" id="initCompilation" onclick="initCompilation('<?=get_data('processUri')?>','<?=get_data('deliveryClass')?>')">
	<b>	<?if(get_data('isCompiled')):?>
			<?=__('Recompile')?> 
		<?else:?>
			<?=__('Compile')?>
		<?endif;?>
	</b>
	</a>
	<br/>
	<br/>
	<br/>
	
	<script type="text/javascript" src="<?=BASE_WWW?>js/deliveryCompiling.js"></script>
	
	<div id="progressbar"></div>
	<br/>
	<br/>
	<br/>
	<div id="testsContainer"></div>
	
</div>