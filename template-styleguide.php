<?php
/**
* Template Name: Style Guide
*/
get_header(); ?>
<div class="wrap" role="document">
	<div class="container">
		<div class="content">
			<div class="content-inner has-sidebar">
				<div class="row">
					<aside class="sidebar col-md-3" role="complementary">
						<?php get_sidebar(); ?>
					</aside>
					<main class="main col-md-9" role="main">
						<?php dw_kido_site_header_mobile(); ?>
						<header class="page-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</header>
						<article class="hentry page comments-close">
							<h3 style="margin-top: 0">Button</h3>
							<div class="row">
								<div class="col-sm-4"><button type="button" class="btn btn-block btn-default">Default</button></div>
								<br class="visible-xs-block">
								<div class="col-sm-4"><button type="button" class="btn btn-block btn-primary">Primary</button></div>
								<br class="visible-xs-block">
								<div class="col-sm-4"><button type="button" class="btn btn-block btn-success">Success</button></div>
							</div>

							<br>

							<div class="row">
								<div class="col-sm-4"><button type="button" class="btn btn-block btn-info">Info</button></div>
								<br class="visible-xs-block">
								<div class="col-sm-4"><button type="button" class="btn btn-block btn-warning">Warning</button></div>
								<br class="visible-xs-block">
								<div class="col-sm-4"><button type="button" class="btn btn-block btn-danger">Danger</button></div>
							</div>
							
							<br> <br>

							<h3>Alerts</h3>
							<div class="row">
								<div class="col-sm-12">
									<div class="alert alert-success" role="alert">
										You successfully read this important alert message.
									</div>

									<div class="alert alert-info" role="alert">
										This alert needs your attention.
									</div>

									<div class="alert alert-warning" role="alert">
										Better check yourself, you're not looking too good.
									</div>

									<div class="alert alert-danger" role="alert">
										Change a few things up and try submitting again.
									</div>
								</div>
							</div>

							<br>

							<h3>Headding</h3>
							<div class="row">
								<div class="col-sm-12">
									<h1>Heading 1 <small class="hidden-xs">Secondary text</small></h1>
									<h2>Heading 2 <small class="hidden-xs">Secondary text</small></h2>
									<h3>Heading 3 <small class="hidden-xs">Secondary text</small></h3>
									<h4>Heading 4 <small class="hidden-xs">Secondary text</small></h4>
									<h5>Heading 5 <small class="hidden-xs">Secondary text</small></h5>
									<h6>Heading 6 <small class="hidden-xs">Secondary text</small></h6>
								</div>
							</div>

							<br>

							<h3>Form fields</h3>
							<div class="row">
								<div class="col-sm-12">
									<form>
										<div class="row">
											<div class="col-sm-7">
												<div class="row">
													<div class="col-sm-6">
														<input type="text" class="form-control" placeholder="First Name">
													</div>

													<br class="visible-xs-block">

													<div class="col-sm-6">
														<input type="text" class="form-control" placeholder="Last Name">
													</div>
												</div>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="form-group has-success">
												<div class="col-sm-7">
													<input type="text" class="form-control" placeholder="Username">
												</div>
												<label class="control-label col-sm-5" for="inputSuccess4">Input with success</label>
											</div>
										</div>
										
										<br class="hidden-xs">

										<div class="row">
											<div class="form-group has-error">
												<div class="col-sm-7">
													<input type="email" class="form-control" placeholder="Email address">
												</div>
												<label class="control-label col-sm-5" for="inputSuccess4">Please correct the error</label>
											</div>
										</div>
										
										<br class="hidden-xs">

										<div class="row">
											<div class="col-sm-7">
												<fieldset disabled="">
													<input type="text" class="form-control" placeholder="Text input">
												</fieldset>
											</div>
										</div>
										
										<br>

										<div class="row">
											<div class="col-sm-7">
												<textarea class="form-control" rows="5"></textarea>
											</div>
										</div>
										
										<br>
										
										<div class="row">
											<div class="col-sm-4">
												<select class="form-control">
													<option>Select your Language</option>
													<option>English</option>
													<option>German</option>
													<option>korean</option>
												</select>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-sm-12">
												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														Cocacola
													</label>
												</div>

												<div class="checkbox disabled">
													<label>
														<input type="checkbox" value="" disabled="">
														Pepsi
													</label>
												</div>

												<div class="checkbox">
													<label>
														<input type="checkbox" value="">
														SevenUp
													</label>
												</div>
											</div>
										</div>

										<br>

										<button type="button" class="btn btn-default">Default</button>
									</form>
								</div>
							</div>						
						</article>
					</main>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>