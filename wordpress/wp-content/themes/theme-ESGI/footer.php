			<footer id="site-footer">
				<div class="row">
					<div class="col-md-4 offset-md-1 justify-content-start row">
						<div class="col-md-12 justify-content-start d-flex relative">
							<?= getIcon('esgi') ?>
							<span class="absolute"><?= getIcon('dot') ?></span>
						</div>
					</div>

					<div class="col-md-4 offset-md-2 justify-content-start row">
						<div class="d-flex justify-content-between">
							<div class="site-footer__contact">
								<span>Manager</span>
								<ul>
									<li>+33 1 53 31 25 23</li>
									<li>info@esgi.com</li>
								</ul>
							</div>
	
							<div class="site-footer__contact">
								<span>CEO</span>
								<ul>
									<li>+33 1 53 31 25 25</li>
									<li>ceo@company.com</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex justify-content-between mt-5">
					<p class="col-md-4">2022  Figma Template by ESGI</p>
					<div class="col-md-3">
						<?= getIcon('linkedinAndFacebook') ?>
					</div>
				</div>

			</footer>
		<?php wp_footer(); ?>
	</body>
</html>