<?php

$this->title = Yii::t('app', 'Premium');
use yii\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;


$this->registerCss(
	"
	.rounded-lg {
		border-radius: 1rem !important;
	}

	.text-small {
		font-size: 0.9rem !important;
	}

	.custom-separator {
		width: 5rem;
		height: 6px;
		border-radius: 1rem;
	}

	.text-uppercase {
		letter-spacing: 0.2em;
	}
 "
);
?>

<div class="card">
	<?= $this->render('/admin/_alert_flash', []) ?>
	<div class="card-header">
		<h3 class="card-title">Premium</h3>
		<div class="card-tools">
			<!-- Buttons, labels, and many other things can be placed here! -->
			<!-- Here is a label for example -->
			<span class="badge badge-primary"></span>
		</div>
		<!-- /.card-tools -->
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<section>
			<div class="container py-5">
				<div class="row text-center align-items-end">
					<!-- Pricing Table-->
					<div class="col-lg-4 mb-5 mb-lg-0">
						<div class="bg-white p-5 rounded-lg shadow">
							<h1 class="h6 text-uppercase font-weight-bold mb-4">Basic</h1>
							<h2 class="h1 font-weight-bold">$199<span class="text-small font-weight-normal ml-2">/ month</span></h2>

							<div class="custom-separator my-4 mx-auto bg-primary"></div>

							<ul class="list-unstyled my-5 text-small text-left">
								<li class="mb-3">
									<i class="fa fa-check mr-2 text-primary"></i> Video Stream</li>
									<li class="mb-3">
										<i class="fa fa-check mr-2 text-primary"></i> No ads</li>
										<li class="mb-3">
											<i class="fa fa-check mr-2 text-primary"></i> 24 hours support</li>
											<li class="mb-3 text-muted">
												<i class="fa fa-times mr-2"></i>
												<del>Unlimited Stream</del>
											</li>
											<li class="mb-3 text-muted">
												<i class="fa fa-times mr-2"></i>
												<del>4K support</del>
											</li>
											<li class="mb-3 text-muted">
												<i class="fa fa-times mr-2"></i>
												<del>Priority Stream</del>
											</li>
										</ul>
										<a href="#" class="btn btn-default btn-block p-2 shadow rounded-pill">Coming Soon</a>
									</div>
								</div>
								<!-- END -->


								<!-- Pricing Table-->
								<div class="col-lg-4 mb-5 mb-lg-0">
									<div class="bg-white p-5 rounded-lg shadow">
										<h1 class="h6 text-uppercase font-weight-bold mb-4">Pro</h1>
										<h2 class="h1 font-weight-bold">$399<span class="text-small font-weight-normal ml-2">/ month</span></h2>

										<div class="custom-separator my-4 mx-auto bg-primary"></div>

										<ul class="list-unstyled my-5 text-small text-left font-weight-normal">
											<li class="mb-3">
												<i class="fa fa-check mr-2 text-primary"></i> Video Stream</li>
												<li class="mb-3">
													<i class="fa fa-check mr-2 text-primary"></i>  No ads</li>
													<li class="mb-3">
														<i class="fa fa-check mr-2 text-primary"></i> 24 hours support</li>
														<li class="mb-3">
															<i class="fa fa-check mr-2 text-primary"></i> Unlimited Stream</li>
															<li class="mb-3">
																<i class="fa fa-check mr-2 text-primary"></i> 4k Support</li>
																<li class="mb-3 text-muted">
																	<i class="fa fa-times mr-2"></i>
																	<del>Priority Stream</del>
																</li>
															</ul>
															<a href="#" class="btn btn-default btn-block p-2 shadow rounded-pill">Coming Soon</a>
														</div>
													</div>
													<!-- END -->


													<!-- Pricing Table-->
													<div class="col-lg-4">
														<div class="bg-white p-5 rounded-lg shadow">
															<h1 class="h6 text-uppercase font-weight-bold mb-4">Enterprise</h1>
															<h2 class="h1 font-weight-bold">$899<span class="text-small font-weight-normal ml-2">/ month</span></h2>

															<div class="custom-separator my-4 mx-auto bg-primary"></div>

															<ul class="list-unstyled my-5 text-small text-left font-weight-normal">
																<li class="mb-3">
																	<i class="fa fa-check mr-2 text-primary"></i> Video Stream</li>
																	<li class="mb-3">
																		<i class="fa fa-check mr-2 text-primary"></i>No ads</li>
																		<li class="mb-3">
																			<i class="fa fa-check mr-2 text-primary"></i> 24 hours support</li>
																			<li class="mb-3">
																				<i class="fa fa-check mr-2 text-primary"></i> Unlimited Stream</li>
																				<li class="mb-3">
																					<i class="fa fa-check mr-2 text-primary"></i>  4k Support</li>
																					<li class="mb-3">
																						<i class="fa fa-check mr-2 text-primary"></i>Priority Stream</li>
																					</ul>
																					<a href="#" class="btn btn-default btn-block p-2 shadow rounded-pill">Coming Soon</a>
																				</div>
																			</div>
																			<!-- END -->

																		</div>
																	</div>
																</section>
	</div>
	<!-- /.card-body -->
	<div class="card-footer">
	</div>
	<!-- /.card-footer -->
</div>
<!-- /.card -->