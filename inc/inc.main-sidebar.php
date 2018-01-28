<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
			<img src="img/profile_pictures/default.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
			<p><?php echo $_SESSION['userFirstName']; ?> <?php echo $_SESSION['userLastName']; ?></p>
			<!-- Status -->
			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>

		<!-- search form -->
		<form action="#" method="get" class="sidebar-form">
			<div class="input-group">
			<input type="text" name="q" class="form-control" placeholder="Search...">
			<span class="input-group-btn">
				<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
				</button>
				</span>
			</div>
		</form>
		<!-- /.search form -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="<?= ($activePage == 'dashboard') ? 'active':''; ?>">
				<a href="dashboard"><i class="fa fa-link"></i> <span>Dashboard</span></a>
			</li>
			<?php
				if($_SESSION['userLevel'] == '1'){
					// Administrator
					?>
						<li class="<?= ($activePage == 'users') ? 'active':'treeview'; ?>">
							<a href="#"><i class="fa fa-link"></i> <span>Users</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="users">New User</a></li>
								<li><a href="users" id="view-users">View Users</a></li>
							</ul>
						</li>
					<?php
				}else{
					?>
						<li class="<?= ($activePage == 'new-company' || $activePage == 'view-companies') ? 'active':'treeview'; ?>">
							<a href="#"><i class="fa fa-link"></i> <span>Companies</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="new-company">New Company</a></li>
								<li><a href="view-companies">View Companies</a></li>
							</ul>
						</li>

						<li class="<?= ($activePage == 'new-contact' || $activePage == 'view-contacts') ? 'active':'treeview'; ?>">
							<a href="#"><i class="fa fa-link"></i> <span>Contacts</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<li><a href="new-contact">New Contact</a></li>
								<li><a href="view-contacts">View Contacts</a></li>
							</ul>
						</li>
					<?php
				}
			?>
			
			<li class=""><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
			<li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
		</ul>
		<!-- /.sidebar-menu -->

		<!-- Sidebar Menu -->
		<!-- <ul class="sidebar-menu" data-widget="tree">
			<li class="header">HEADER</li>
			
			<li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
			<li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
			<li class="treeview">
			<a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#">Link in level 2</a></li>
				<li><a href="#">Link in level 2</a></li>
			</ul>
			</li>
		</ul> -->
		<!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>