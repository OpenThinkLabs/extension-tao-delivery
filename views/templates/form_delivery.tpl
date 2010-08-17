<?include('header.tpl')?>

<style type="text/css">
	div.data-container{
		width:44%;
	}
	
	#delivery-left-container{
		float:left;
		position:absolute;
		width:50%;
	}
	
	#delivery-main-container{
		margin-left:46%;
	}
</style>
   
<div id="delivery-left-container">
		<?if(get_data('authoringMode') == 'simple'):?>
		
		<?include('delivery_tests.tpl');?>
		<div class="breaker"></div>
		<?endif?>
		
		<?include('groups.tpl')?>
		<?include('subjects.tpl')?>
		<div class="breaker"></div>
		
		<?include('delivery_campaign.tpl')?>
		<div class="breaker"></div>
		
</div>

<div class="main-container" id="delivery-main-container">
	<div id="form-title" class="ui-widget-header ui-corner-top ui-state-default">
		<?=get_data('formTitle')?>
	</div>
	<div id="form-container" class="ui-widget-content ui-corner-bottom">
		<?=get_data('myForm')?>
	</div>
	
	<div id="form-title" class="ui-widget-header ui-corner-top ui-state-default" style="margin-top:0.5%;">
		<?=__("Compilation")?>
	</div>
	<div id="form-compile" class="ui-widget-content ui-corner-bottom">
		<div class="ext-home-container ui-state-highlight">
		<p>
		<?if(get_data('isCompiled')):?>
			<?=__('The delivery was last compiled on')?> <?=get_data('compiledDate')?>.
		<?else:?>
			<?=__('The delivery is not compiled yet')?>
		<?endif;?>
		</p>
		<p>
			<img id='compileLinkImg' src="<?=BASE_WWW?>img/compile_small.png"/>&nbsp;
			<a id='compileLink' class='compileLink' href="#">
				<b>
				<?if(get_data('isCompiled')):?>
					<?=__('Recompile')?> 
				<?else:?>
					<?=__('Compile')?>
				<?endif;?>
				</b>
			</a>
		</p>
		</div>
	</div>
	
	<?include('delivery_history.tpl');?>
	
</div>


<script type="text/javascript">
$(function(){
	// $('label.form_desc').each(function(){
		// var parentElt = $(this).parent();
		// if($(this).width()>0.3*parseInt(parentElt.width())){
			// $('<br/>').insertAfter($(this));
		// }
	// });

	$("#compileLink,#compileLinkImg,.compileLink").click(function(){
		$("a[title=compile]").click();
		return false;
	});
});
</script>

<?include('footer.tpl');?>