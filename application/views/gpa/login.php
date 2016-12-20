<?php include 'header.php'; ?>
	
	<div class="container">
		
		<form action="/gpa/login" method="get">
			<div class="form-group">
				<label>Student ID</label>
				<input type="text" class="form-control" name="userid">
			</div>
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" name="name" placeholder="Please use English">
			</div>
			<button type="submit" class="btn btn-primary">Login</button>
		</form>
	
	</div>


<?php include 'footer.php'; ?>