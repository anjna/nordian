		<option value="">Select Chapter</option>
	<?php
			
			foreach($chapters as $key => $chapter)
			{
		?>	
				<option value="<?php echo $key; ?>">
					<?php echo $chapter; ?>				
				</option>
		<?php
			}
	?>