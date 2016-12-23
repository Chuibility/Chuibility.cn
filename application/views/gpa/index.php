<?php include 'header.php'; ?>
	
	<div class="container">
		
		<div class="jumbotron text-xs-center">
			
			<h1>密院活动假人排行榜</h1>
			
			<p class="lead">UM-SJTU-JI GPA Scoreboard</p>
		
		</div>
		
		<div class="text-xs-center">
			<div class="row">
				<div class="col-sm-1">No.</div>
				<div class="col-sm-3">Name</div>
				<div class="col-sm-2">Core GPA</div>
				<div class="col-sm-2">Core Credits</div>
				<div class="col-sm-2">Total GPA</div>
				<div class="col-sm-2">Total Credits</div>
			</div>
		</div>
		<?php $no = 0; ?>
		<?php foreach ($list as $key => $item): ?>
			<?php if ($item->total_credit > 0): ?>
				<div class="row text-xs-center">
				<div class="col-sm-1"><?= ++$no ?></div>
				<?php if ($item->open == '1' && $user->open == '1' && $user->chuibility == '1'): ?>
					<div class="col-sm-3"><a href="/gpa/edit?id=<?= $item->userid ?>"><?= $item->name ?></a></div>
				<?php else: ?>
				<div class="col-sm-3"><?= $item->name ?></div>
			<?php endif; ?>
			<div class="col-sm-2"><?= sprintf('%.4f', $item->core_gpa) ?></div>
			<div class="col-sm-2"><?= $item->core_credit ?></div>
			<div class="col-sm-2"><?= sprintf('%.4f', $item->total_gpa) ?></div>
			<div class="col-sm-2"><?= $item->total_credit ?></div>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
	
	<br>

<?php include 'footer.php'; ?>