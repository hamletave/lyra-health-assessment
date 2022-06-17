			<?php
			// If Single or Archive (Category, Tag, Author or a Date based page)
			if (is_single() || is_archive()) :
			?>
				</div><!-- /.col -->

				</div><!-- /.row -->
			<?php
			endif;
			?>
			</main><!-- /#main -->
			<footer id="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<p><?php printf(esc_html__('&copy; %1$s %2$s. All rights reserved.', 'lyra-assessment'), date_i18n('Y'), get_bloginfo('name', 'display')); ?></p>
						</div>
					</div><!-- /.row -->
				</div><!-- /.container -->
			</footer><!-- /#footer -->
			</div><!-- /#wrapper -->
			<?php
			wp_footer();
			?>
			</body>

			</html>