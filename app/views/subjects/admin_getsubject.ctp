	<table width="100%" cellpadding="0" cellspacing="0" class="grid2">

		<tr>
			<td width="5%"></td>
			<td width="45%">Code</td>
			<td width="50%">Name</td>
		</tr>
				
		<?php
			foreach($subjects as $subject)
			{
				$subjectID = $subject['Subject']['id'];
		?>	
				<tr>
					<td><input type="radio" name="data[Subject][existsubject][" value="<?php echo $subjectID; ?>" ></td>
					<td><?php echo $subject['Subject']['intcode']; ?></td>
					<td><?php echo $subject['Subject']['name']; ?></td>
				</tr>
		<?php
			}
		?>
	
	</table>
	<div style="line-height:10px;">&nbsp;</div>
	<table width="100%" cellpadding="0" cellspacing="0" class="grid2">
	<tr><td colspan="2">Also copy following content
	</td></tr>
	<tr><td><input checked type="checkbox" name="data[Subject][copy][]" value="all" id="checkall" />&nbsp;&nbsp;All</td><td><input checked class="content" type="checkbox" value="c" name="data[Subject][copy][]" />&nbsp;&nbsp;Chapters</td></tr>
	<tr><td><input class="content" checked type="checkbox" value="cs" name="data[Subject][copy][]" />&nbsp;&nbsp;Chapter & Summary
	</td><td><input  class="content" checked type="checkbox" value="cq" name="data[Subject][copy][]" />&nbsp;&nbsp;Chapter & Questions
	</td></tr>
	</table>
	<script>
		
		$( "#checkall" ).click(function() {
			//alert('ddd');
			if ($("#checkall").is(':checked')) {
					
					$(".content").prop("checked", true);

			} else {
				//alert('ncheck');
					$(".content").prop("checked", false);
				
			}
		});
		
		$( ".content" ).click(function() {
			//alert('ddd');
			if ($(this).is(':checked')) {
					
					//$(".content").prop("checked", true);

			} else {
				//alert('ncheck');
					$("#checkall").prop("checked", false);
				
			}
		});
		
	</script>
	
	