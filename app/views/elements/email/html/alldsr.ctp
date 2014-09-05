<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <body>
	 <h1>DSR Report</h1><table border='2'>
				<tr>
				<th>Employee Name</th>
				<th>Project  Id</th>
				<th>Project Reference</th>
				<th>Task Description</th>
				<th>Project Type</th>
				<th>Remarks</th></tr>
	<?php 
	
	foreach($alldata as $alldsr)
	{
	?>
				<tr>
				<td><?php echo $alldsr['Admin']['fullname'];?></td>
				<td><?php echo $alldsr['Task']['project_id'];?></td>
				<td><?php echo $alldsr['Task']['project_reference'];?></td>
				<td><?php echo $alldsr['Task']['task_description'];?></td>
				<td><?php echo $alldsr['Task']['project_type'];?></td>
				<td><?php echo $alldsr['Task']['remarks'];?></td></tr>
    <?php 
	}
	?>
	
	</body>
</html>