<nav class="navbar header-navbar pcoded-header">
	<div class="navbar-wrapper">

		<div class="navbar-logo">
			<a class="mobile-menu" id="mobile-collapse" href="#!">
				<i class="ti-menu"></i>
			</a>
			<a class="mobile-search morphsearch-search" href="#">
				<i class="ti-search"></i>
			</a>
			<a href="index.html">
				<img class="img-fluid" src="{{ asset('assets/images/logo.png')}}" alt="Theme-Logo" />
			</a>
			<a class="mobile-options">
				<i class="ti-more"></i>
			</a>
		</div>

		<div class="navbar-container container-fluid">
			<ul class="nav-left">
				<li>
					<div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
				</li>

				<li>
					<a href="#!" onclick="javascript:toggleFullScreen()">
						<i class="ti-fullscreen"></i>
					</a>
				</li>
			</ul>
			<ul class="nav-right">
				<li class="user-profile header-notification">
					<a href="#!">
						<img src="{{ Storage::url($user->profile_photo_path) }}" class="img-radius" alt="User-Profile-Image">
						<span>{{ $user->name }}</span>
						<i class="ti-angle-down"></i>
					</a>
					<ul class="show-notification profile-notification">
						<li>
							<a href="{{ route('profile.edit')}}">
								<i class="ti-user"></i> Profile
							</a>
						</li>
						<li>
							<a href="{{ route('signout') }}">
								<i class="ti-layout-sidebar-left"></i> Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
