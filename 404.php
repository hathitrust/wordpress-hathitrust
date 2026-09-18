<?php

	get_header();

?>
<div class="container error-wrapper" id="page-content">
          <section class="d-flex flex-column">
            <div class="d-flex flex-column message-wrapper">
              <div class="d-flex flex-column-reverse gap-2">
                <h1>Page not found</h1>
                <h2 class="text-uppercase error-code">Error: 404</h2>
              </div>
<?php

	get_template_part( 'inc/sidebar-block', 'html' );

?>
	 </div>

            <div class="d-flex flex-column gap-3 help-links">
              <p>Here are a few links that may be helpful:</p>
              <ul class="m-0 p-0 list-unstyled d-flex gap-3">
                <li><a href="https://www.hathitrust.org">Home</a></li>
                <li><a href="https://babel.hathitrust.org/cgi/ls?a=page&page=advanced">Advanced Search</a></li>
                <li><a href="https://hathitrust.atlassian.net/servicedesk/customer/portals">Help Center</a></li>
                <li>
                  <a href="#" data-hathi-trigger="hathi-feedback-form-modal" id="feedback-form">Report a Problem</a>
                </li>
              </ul>
            </div>
            <hathi-feedback-form-modal data-prop-form="error" data-prop-is-open="false"></hathi-feedback-form-modal>
          </section>
        </div>
<?php

	get_footer();

?>
