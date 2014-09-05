		<option value="">Select Subject</option>
	<?php
			
			foreach($subjects as $key => $subject)
			{
		?>	
				<option value="<?php echo $key; ?>">
					<?php echo $subject; ?>				
				</option>
		<?php
			}
	?>