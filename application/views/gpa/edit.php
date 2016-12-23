<?php include 'header.php'; ?>

<div class="container">
	
	<?php if ($other): ?>
		<div class="text-xs-center">
			<h5>
				Checking GPA of <?= $user->name; ?>
			</h5>
		</div>
	<?php else: ?>
		
		<?php if (!$permission): ?>
			<div class="text-xs-center">
				<h5>
					You don't have the permission to check his/her GPA<br>
					It's because you or him/her haven't set it open to others<br>
					Or you are not permitted by the site holder.
				</h5>
			</div>
			<?php else: ?>
			<div class="text-xs-center">
				<h5>
					If you open your GPA to others, those who also open their GPA can see yours.<br>
					It is called the GPL License.
				</h5>
			</div>
		<?php endif; ?>
		
		<?php if ($user->open == '1'): ?>
			<!--<a class="btn btn-outline-warning" href="/gpa/edit/close">Hide to public</a>-->
		<?php else: ?>
			<a class="btn btn-outline-success" href="/gpa/edit/open">Open to public (permanently)</a>
		<?php endif; ?>
		
		
		<button class="btn btn-outline-primary" id="btn-add">Add</button>
	<?php endif; ?>
	<br><br>
	
	
	<div class="card" id="form-add" style="display: none">
		<div class="card-block row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="form-cource">Course:</label>
					<div id="form-cource" class="btn-group">
						<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
						        aria-haspopup="true" aria-expanded="false" id="btn-course">Select
						</button>
						<div class="dropdown-menu" id="course-munu">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="form-cource">Grade:&nbsp;</label>
					<div id="form-cource" class="btn-group">
						<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
						        aria-haspopup="true" aria-expanded="false" id="btn-grade">
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">A+</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">A</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">A-</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">B+</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">B</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">B-</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">C+</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">C</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">C-</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">D</a>
							<a class="dropdown-item grade-menu-item" href="javascript:void(0);">F</a>
						</div>
					</div>
				</div>
				<button class="btn btn-outline-success" id="btn-submit">Submit</button>
			</div>
			<div class="col-sm-6">
				<p>
					TH000 思想道德修养与法律基础<br>
					TH004 军事理论<br>
					TH007 马克思主义基本原理<br>
					TH009 形势与政策<br>
					TH012 毛泽东思想和中国特色社会主义理论体系概论<br>
					TH021 中国近现代史纲要<br>
				</p>
			</div>
		</div>
	</div>
	
	<div class="text-xs-center" id="gpalist">
		<div class="row">
			<div class="col-sm-2">Course ID</div>
			<div class="col-sm-2">Grade</div>
			<div class="col-sm-2">GPA</div>
			<div class="col-sm-2">Credits</div>
			<div class="col-sm-2">Core</div>
			<?php if (!$other): ?>
				<div class="col-sm-2">Operation</div>
			<?php endif; ?>
		</div>
		<hr>
		<?php foreach ($gpa_list as $item): ?>
			<div class="row">
				<div class="col-sm-2"><?= $item->courseid ?></div>
				<div class="col-sm-2"><?= $item->letter ?></div>
				<div class="col-sm-2"><?= sprintf('%.1f', min(40, $item->grade) / 10) ?></div>
				<div class="col-sm-2"><?= $item->credit ?></div>
				<div class="col-sm-2"><?= $item->core == '1' ? '√' : '×' ?></div>
				<?php if (!$other): ?>
					<div class="col-sm-2">
						<button class="btn btn-sm btn-outline-danger btn-delete" data-id="<?= $item->courseid ?>">Delete
						</button>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	
	<hr>
	
	<div class="row text-xs-center" id="gpa">
		<div class="col-sm-6"><h5>Core GPA:&nbsp;<?= sprintf('%.4f', $gpa['core_gpa']) ?></h5></div>
		<div class="col-sm-6"><h5>Core Credits:&nbsp;<?= $gpa['core_credit'] ?></h5></div>
		<div class="col-sm-6"><h5>Total GPA:&nbsp;<?= sprintf('%.4f', $gpa['total_gpa']) ?></h5></div>
		<div class="col-sm-6"><h5>Total Credits:&nbsp;<?= $gpa['total_credit'] ?></h5></div>
	</div>

</div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
	$(document).ready(function ()
	{
		var course_list = JSON.parse('<?php echo json_encode($course);?>');
		
		//var gpa_list = JSON.parse('<?php echo json_encode($gpa_list);?>');
		
		//var gpa = JSON.parse('<?php echo json_encode($gpa);?>');
		
		var grade_list = {
			'43': 'A+', '40': 'A', '37': 'A-', '33': 'B+', '30': 'B', '27': "B-",
			'23': 'C+', '20': 'C', '17': 'C-', '10': 'D', '0': 'F'
		};
		
		console.log(gpa);
		
		$("#btn-grade").html('A');
		
		for (var index in course_list)
		{
			$("#course-munu").append('<a class="dropdown-item course-menu-item" href="javascript:void(0);">'
			                         + course_list[index] + '</a>');
		}
		
		$(".course-menu-item").click(function (e)
		{
			$("#btn-course").html($(e.target).html());
		});
		
		$(".grade-menu-item").click(function (e)
		{
			$("#btn-grade").html($(e.target).html());
		});
		
		$("#btn-add").click(function ()
		{
			$("#form-add").css('display', 'block');
		});
		
		$("#btn-submit").click(function ()
		{
			var courseid = $("#btn-course").html();
			
			if (courseid == 'Select')
			{
				return;
			}
			var grade = $("#btn-grade").html();
			var url = '<?php echo base_url('gpa/edit/submit');?>?courseid=' + courseid + '&grade=' +
			          encodeURIComponent(grade);
			console.log(url);
			location.href = url;
		});
		
		$(".btn-delete").click(function (e)
		{
			var courseid = $(e.target).data('id');
			var url = '<?php echo base_url('gpa/edit/remove');?>?courseid=' + courseid;
			location.href = url;
		});
	})
</script>
