<?php

	get_header();

	if ( have_posts() ) {
		while ( have_posts() ) { the_post();

			get_template_part( 'inc/breadcrumbs' );

            $override = get_field( 'title_override' );
			$title = $override ? $override : get_the_title();

			

?>
<div class="strategic-vision-banner" style="grid-area:2/1">
    <div class="sv-banner-inner">
        <p class="text-white">Updated May 2024</p>
        <h2 class="text-white bold d-flex flex-column">HathiTrust <span>Strategic Vision</span></h2>
            <a class="btn btn-outline-light" href="https://www.hathitrust.org/wp-content/uploads/2024/03/HathiTrust-Strategic-Vision-2024.pdf">Download the Strategic Vision <i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a>
    </div>
</div>
<div class="twocol" style="grid-area:3/1">
    <div class="twocol-side">
            <h1><?= wp_kses_post( $title ); ?></h1>
    <?php

                if ( have_rows( 'sidebar_blocks' ) ) {
                    while ( have_rows( 'sidebar_blocks' ) ) { the_row();
                        get_template_part( 'inc/sidebar-block', get_row_layout() );
                    }
                }

    ?>
	</div>
	<div class="twocol-main" id="page-content">
		<div class="mainplain" id="strategic-vision">
            <h2 class="pb-4" id="from-the-executive-director">From the Executive Director</h2>
            <div class="pb">
                <div class="pb-contents">
                    <p class="mb-3">We are pleased to introduce HathiTrust's new Strategic Vision, created through an intense year-long effort to imagine HathiTrust's future. Fifteen years after our launch, this strategic vision not only responds to the changed circumstances of our member libraries, the world and HathiTrust itself, but builds on our existing strengths to outline critical and meaningful work over the next three to five years. We are excited about this work and will continually share our progress on advancing our vision.</p>
                    <p class="exbold">— Mike Furlough</p>
                </div>
            </div>

            <h2 class="pb-4" id="committed-to-the-core">Committed to the Core</h2>
            <p>We renew our commitment to the stewardship and preservation of our collection, the foundation of all HathiTrust's work. Explore our strategic vision and learn how it brings our mission, vision, and values forward into our next decade.</p>
            <figure>
                <picture>
                    <source media="(max-width: 769px)" srcset="<?php echo get_template_directory_uri(); ?>/images/sv/CommittedCore_345x230.webp" type="image/webp">
                    <source srcset="<?php echo get_template_directory_uri(); ?>/images/sv/CommittedCore_700x400.webp" type="image/webp">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/sv/CommittedCore_700x400.png" alt="" loading="lazy">
                </picture>
                <figcaption class="caption"><span class="bold">Image:</span> Fludd, Robert and Galler, Hieronymus. <span class="ital">Utriusque cosmi maioris scilicet et minoris metaphysica, physica atque technica historia.</span> Oppenheim, 1617. Contributed by Getty Research Institute.</figcaption>
            </figure>
            <h2 class="pb-4" id="strategic-directions">Strategic Directions</h2>
            <p>With this new Strategic Vision, the lens through which HathiTrust will plan and execute its work will be re-focused on the collection, ensuring that it is rich, broad, discoverable, and useful. To fulfill our values, ambition, and ideals most effectively, we must prioritize and focus our efforts and play to our strengths. Our Strategic Vision looks far ahead, while focusing and organizing work for a 3-5-year horizon. Our Strategic Directions and Objectives reflect the core priorities that will focus HathiTrust's time, attention, and its members' resources to fulfill our established <a href="/about/mission-history/">Mission, Vision, Goals and Values</a>, and to support conscious growth, scale, innovation, agility, and responsiveness in 2024 and beyond. </p>
            <p class="bold mb-0">While described separately and in numerical order, these Directions and Objectives are not listed in priority order, nor are they discretely separable or sequential in practice. They are overlapping, connected, and part of a symbiotic whole.</p>

            <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button allcaps" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Directon 1: Increase Access and Use
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <p>We will expand access to and increase use of copyrighted, open, and public domain works in the HathiTrust collection.</p>
                        <p class="bold">Objectives</p>
                        <ol type="a">
                            <li>Investigate, analyze, and respond to the diversity of our users' needs and practices.</li>
                            <li>Expand the modes of lawful access to in-copyright works, in partnership with the wider community.</li>
                            <li>Identify more public domain works by further automating and scaling copyright review processes to identify eligible works.</li>
                            <li>Integrate lawful and ethical computational methods and tools into service offerings, access, workflows, and system improvements.</li>
                            <li>Engage other organizations involved in print preservation so that we contribute to the larger ecosystem based on our greatest and unique strengths.</li>
                        </ol>
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button collapsed allcaps" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        Direction 2: Expand and Diversify the Collection
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body">
                        <p>We will expand the volume and diversity of book and serial content in the HathiTrust collection.</p>
                        <p class="bold">Objectives</p>
                        <ol type="a">
                            <li>Enable members to identify, digitize, preserve, and contribute their unique content to the collection—especially that of underrepresented and historically-marginalized voices and perspectives.</li>
                            <li>Invite organizations engaged in mass digitization of book and serial content, that are not currently members, to contribute and preserve their collections with HathiTrust.</li>
                            <li>Build collaborations in support of scholarship and our libraries that will enable us to develop a collection that works towards a more just society, and towards resilience in response to changing economic, social and environmental conditions.</li>
                            <li>Develop mutually beneficial relationships with scholarly publishers to enable increased discovery, access, and use of their open and in-copyright content.</li>
                        </ol>
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                    <button class="accordion-button collapsed allcaps" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        Direction 3: Enrich Texts and Metadata
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                    <div class="accordion-body">
                        <p>We will expand access to and increase use of copyrighted, open, and public domain works in the HathiTrust collection.</p>
                        <p class="bold">Objectives</p>
                        <ol type="a">
                            <li>Apply existing and emerging computational tools and methods in service of text and metadata improvement.</li>
                            <li>Actively manage and share bibliographic metadata entrusted to our care.</li>
                            <li>Prioritize investments in enriching text and metadata to make the collection more discoverable, findable, and usable.</li>
                        </ol>
                    </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                    <button class="accordion-button collapsed allcaps" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                        Direction 4: Invest In Core, Enabling Infrastructure
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                    <div class="accordion-body">
                    <p>We will reinforce our technological and operational foundations to preserve and steward the HathiTrust collection responsibly, sustainably, and effectively.</p>
                    <p class="bold">Objectives</p>
                    <ol type="a">
                        <li>Ensure resilience and sustainability of our preservation infrastructure by addressing technical debt in legacy systems.</li>
                        <li>Improve the search and discovery of all collections, in multiple languages.</li>
                        <li>Streamline the collections ingest deposit process.</li>
                        <li>Develop robust collection analysis tools and usage statistics for both operational uses and for members' uses.</li>
                        <li>Increase our capacity to assess, develop, and integrate advanced and emerging computational methods into our work and offerings, and do so responsibly and ethically.</li>
                    </ol>
                    </div>
                    </div>
                </div>
            </div>
            
            <h2 class="pb-4" id="creating-our-future">Creating Our Future</h2>
            <p>In its first 15 years, HathiTrust has collected, preserved, and provided lawful access to more than 18 million texts in more than 400 languages. Today we steward the single largest collection of digitized texts created by and for the academic community. HathiTrust depends on its members' digitization, organization, and contribution of their own collections, and assumes a responsibility to its members—and to the world—to preserve and make these texts as accessible as possible. Preservation remains the foundation upon which our ambitions to be a vital catalyst for emerging forms of research, teaching, and learning are based. HathiTrust continues to do this in bold and innovative ways that respect the rights of creators and publishers, and that reflect the diversity of voices and perspectives of the human record.</p>
            <p>HathiTrust provides services for the common good of its members and recognizes the power of its collective action to contribute to the greater public good. HathiTrust began in 2008 with 13 members, growing to 210 as of 2023. In 2019, the adoption of a tier-based membership system enabled a wider diversity of institutions to join, significantly increasing the number of smaller member organizations. HathiTrust members now represent a wider range of organizational abilities, resources, and needs than ever before. Although today a majority of members do not contribute collections for preservation, the entire membership values and supports HathiTrust's work to preserve collections for durable long-term access. Depending upon their capacities and abilities, our diverse membership supports HathiTrust in a variety of ways, such as contributions of staff time, deposits of collections, and through their financial support.</p>
           <figure>
                <picture>
                    <source media="(max-width: 769px)" srcset="<?php echo get_template_directory_uri(); ?>/images/sv/Future_345x230.webp" type="image/webp">
                    <source srcset="<?php echo get_template_directory_uri(); ?>/images/sv/Future_700x400.webp" type="image/webp">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/sv/Future_700x400.png" alt="" loading="lazy">
                </picture>
                <figcaption class="caption"><span class="bold">Image:</span> <span class="ital">American printer and lithographer,</span> v.85 1927 Jul-Dec. Bristol, Connecticut. Contributed by the University of Michigan.</figcaption>
            </figure>
            <h2 class="pb-4" id="mission">Mission</h2>
            <p>The mission of HathiTrust is to contribute to research, scholarship, and the common good by collaboratively collecting, organizing, preserving, communicating, and sharing the record of human knowledge.</p>
            <h2 class="pb-4" id="vision">Vision</h2>
            <p>HathiTrust will be a vital catalyst for emerging forms of research, teaching, and learning that engage the scholarly and cultural record.</p>
            <figure>
                <picture>
                    <source media="(max-width: 769px)" srcset="<?php echo get_template_directory_uri(); ?>/images/sv/Vision_345x230.webp" type="image/webp">
                    <source srcset="<?php echo get_template_directory_uri(); ?>/images/sv/Vision_700x400.webp" type="image/webp">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/sv/Vision_700x400.png" alt="" loading="lazy">
                </picture>
                <figcaption class="caption"><span class="bold">Image:</span> Eddy, Arthur Jerome. <span class="ital">Cubists and Post-impressionism.</span> Chicago, A. C. McClurg & Co., 1914. Contributed by Getty Research Institute.</figcaption>
            </figure>
            <h2 class="pb-4" id="values">Values</h2>
            <p>We continue to look to our values as we promote and maintain access to the portion of the human record that we steward.</p>
            <div class="pbs">
                <div class="pb">
                    <div class="pb-contents">
                        <h3 class="h3">Trust</h3>
                        <p>Trust is paramount, the basis of the preservation and stewardship mission we undertake on behalf of our community.</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <h3 class="h3">Access to knowledge and open inquiry</h3>
                        <p>Access to knowledge and open inquiry are necessary for just societies and for the creation of new scholarship and research.</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <h3 class="h3">Equity, diversity, and inclusion</h3>
                        <p>Equity, diversity, and inclusion promote justice, create communities that thrive, and advance collective knowledge and understanding.</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <h3 class="h3">Resilience</h3>
                        <p>Resilience, created through interdependent work, provides HathiTrust and the library community as a whole with flexibility and strength to address challenging opportunities in a changing system.</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <h3 class="h3">Constructive, meaningful engagement</h3>
                        <p>Constructive, meaningful engagement allows HathiTrust to benefit from the collective expertise of our colleagues, member staff, and users of HathiTrust.</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <h3 class="h3">Leadership</h3>
                        <p>Leadership that embodies both conviction and humility allows us to learn from the communities that constitute HathiTrust.</p>
                    </div>
                </div>
            </div>
            <figure>
                <picture>
                    <source media="(max-width: 769px)" srcset="<?php echo get_template_directory_uri(); ?>/images/sv/Values_345x230.webp" type="image/webp">
                    <source srcset="<?php echo get_template_directory_uri(); ?>/images/sv/Values_700x400.webp" type="image/webp">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/sv/Values_700x400.png" alt="" loading="lazy">
                </picture>
                <figcaption class="caption"><span class="bold">Image:</span> Lançon, Auguste André. <span class="ital">The life of an elephant.</span> London : Seeley and Co. Limited, 1909. Contributed by The Ohio State University.</figcaption>
            </figure>
            <h2 class="pb-4" id="acknowledgements">Acknowledgements</h2>
            <p class="sv-gap">Librarians and staff at our member institutions participated throughout the process, providing a variety of perspectives in every phase. HathiTrust staff shared additional insight, as well as logistical support to the entire process. A group of strategic leaders representing the breadth and depth of the membership provided consistency and continuity throughout the project as the Strategic Visioning Task Force. We are indebted to each of them for the time, expertise, and commitment they dedicated to envisioning HathiTrust's future.</p>
            <p>Hundreds of individuals from 140 different member libraries and peer organization participated in the following activities, the responses to which helped guide the creation of the vision.</p>
            <ul>
                <li>62 1-hour interviews</li>
                <li>267 responses to an online survey</li>
                <li>2023 Fall Membership Meeting, with polls and VTF panel discussion of poll results</li>
                <li>19 Strategic Visioning workshops:</li>
                <ul class="sv-gap">
                    <li>8 Workshops with the Visioning Task Force</li>
                    <li>7 Staff Workshops</li>
                    <li>1 Board Prioritization Workshop</li>
                    <li>1 in-person, all-day Workshop with the Board and members of the VTF and PSC</li>
                    <li>2 Member Workshops (1 in GMT+ timezones to include international members)</li>
                </ul>
            </ul>
            <p class="sv-gap">Review the complete <a href="/about/mission-history/strategic-visioning/process/">year-long process</a>. For more information or to share your thoughts on HathiTrust's future, please <a href="/contact">contact us</a>.</p>
            <div class="pbs">
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Mike Furlough</p>
                        <p>HathiTrust Executive Director, Co-Chair</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Claire Stewart</p>
                        <p>Chair of HathiTrust Board of Governors, UIUC, Co-Chair</p>
                    </div>
                </div>
            </div>
            <h3 class="allcaps sv-subheading">HathiTrust Strategic Visioning Partners</h3>
            <div class="pbs">
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Megan Hurst</p>
                        <p><a href="https://www.athenaeum21.com/">Athenaeum21 (A21)</a></p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Christine Madsen</p>
                        <p><a href="https://www.athenaeum21.com/">Athenaeum21 (A21)</a></p>
                    </div>
                </div>
            </div>
            <h3 class="allcaps sv-subheading">HathiTrust Strategic Visioning Task Force</h3>
            <div class="pbs">
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Theresa Byrd</p>
                        <p>Dean, University Library, University of San Diego</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Daniel Dollar</p>
                        <p>Associate University Librarian for Scholarly Resources, Yale University</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Kristina Hall</p>
                        <p>Copyright Review Program Manager, HathiTrust</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Dracine Hodges</p>
                        <p>Associate University Librarian for Collections Services, Duke University</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Anne Houston</p>
                        <p>Director of Libraries and College Librarian, Swarthmore College</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Beth Namachchivaya</p>
                        <p>University Librarian, University of Waterloo</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Lorrie McAllister</p>
                        <p>Associate University Librarian for Collection Services and Analysis, Arizona State University</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Nathan Mealey</p>
                        <p>​​Associate University Librarian for Discovery & Access, Wesleyan University</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Catherine Mitchell</p>
                        <p>Director of Publishing, Archives, and Digitization, California Digital Library</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Bethany Nowviskie</p>
                        <p>Dean of Libraries and Professor of English, James Madison University</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Trevor Owens</p>
                        <p>Director of Digital Services, Library of Congress</p>
                    </div>
                </div>
                <div class="pb">
                    <div class="pb-contents">
                        <p class="h3">Denise Pan</p>
                        <p>Senior Associate Dean of University Libraries for Collections and Strategic Partnerships, University of Washington</p>
                    </div>
                </div>            
            </div>
            <h2 class="pb-4" id="principles-for-success">Principles for Success</h2>
            <p>The pace and nature of change in the ecosystems in which we operate necessitate that we plan ahead while remaining flexible and responsive to whatever comes our way. HathiTrust must maintain the ability to respond to our members' needs as they arise, as well as to the environmental, economic, and political events that we will inevitably face. We must therefore carefully consider how to evaluate and maintain existing services, while also making time for the emerging activities that will help us achieve our Strategic Vision. The following processes can help us strike that balance and ensure that we only commit to work that is within the scope of our mission and within our capacity.</p>
            <p class="bold">As part of an active portfolio management process, we will:</p>
            <ul>
                <li>Align our services and programs to meet and anticipate member expectations and needs.</li>
                <li>Regularly evaluate our existing commitments against our mission, vision, directions, and objectives to confirm our direction or to adjust course as needed. Every one to three years we will decide whether to continue, discontinue, or adjust any service or program.</li>
                <li>Deliberately assess new opportunities against our mission, vision, directions, and objectives, clearly articulating the purpose, goal, and intended impacts of any new initiative or project.</li>
                <li>Regularly, prospectively evaluate our resource needs against our commitments, and adjust resources and commitments accordingly.</li>
                <li>Focus on the common good of members first, but always with awareness and intention of the public good we can create.</li>
                <li>Periodically evaluate our governance structure to ensure that it is still appropriate to our activities and the nature of our organization.</li>
                <li>Set and communicate shared expectations for pragmatic yet flexible time horizons that accurately reflect capacity and resources.</li>
                <li>Involve ourselves in the larger communities in which we operate to maintain awareness of emerging needs, issues, trends, and opportunities.</li>
                <li>Evaluate the trade-offs, expectations, and full investments required for partnerships before deciding on a collaborative approach.</li>
                <li>Expect a marathon, but celebrate our sprints. Recognize that ours is a long-term mission and requires long-term commitments. Celebrate and communicate our intermediate successes.</li>
            </ul>
            <figure>
                <picture>
                    <source media="(max-width: 769px)" srcset="<?php echo get_template_directory_uri(); ?>/images/sv/HathiTrust_345x230.webp" type="image/webp">
                    <source srcset="<?php echo get_template_directory_uri(); ?>/images/sv/HathiTrust_700x400.webp" type="image/webp">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/sv/HathiTrust_700x400.png" alt="" loading="lazy">
                </picture>
            </figure>
            <h2 class="pb-4" id="decision-making-framework">Decision-Making Framework</h2>
            <p>We have also adopted a decision-making framework intended to help evaluate existing and new activities against our stated Mission, Vision, Values, and Strategic Directions. While our Strategic Vision guides the organization, this framework can help support decisions by the HathiTrust leadership, Board of Governors, and Staff. The framework is relevant for programs, services, and other initiatives and activities.</p>
            <p>This framework was inspired by the work of the California Digital Library and the documentation that they created for implementation and includes criteria prioritized by the HathiTrust Visioning Task Force, Board, and Staff.</p>
            <p>Used to prompt deep consideration and discussion, the framework poses provocative questions on Organizational Alignment; Ecosystem Implications; Assessment of Trends and Sea Changes; Member Implications; Organizational, Member, and Resource Implications; and Risks.</p>
        </div>
    </div>
</div>
<?php

		}

		get_template_part( 'inc/backtotop' );

	}

	get_footer();

?>