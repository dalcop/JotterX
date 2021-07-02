##### [Version 1.5.5](https://github.com/Codeinwp/neve-pro-addon/compare/v1.5.4...v1.5.5) (2021-05-31)

- [Feat] Add wishlist on the single product
- [Fix] Buttons in the stepped checkout were behaving like a secondary button, thus it caused a font-weight overriding problem
- [Fix] When setting padding values in Blog/Archive layout - only PX can be used but not EM
- [Fix] Background on quantity field on sticky add to cart should inherit the right global color
- [Fix] Smooth scroll instead of snapping to the top on Safari
- [Fix] Individual custom layout Elementor duplicating footer
- [Fix] Do not load dynamic styles of Neve Pro modules when the module is disabled

##### [Version 1.5.4](https://github.com/Codeinwp/neve-pro-addon/compare/v1.5.3...v1.5.4) (2021-05-14)

- [Fix] Fatal error that related to WooCommerce Rest API

##### [Version 1.5.3](https://github.com/Codeinwp/neve-pro-addon/compare/v1.5.2...v1.5.3) (2021-05-12)

- [Fix] Warning that occurs when the quick view opens
- [Fix] WooCommerce Wishlist plugin was causing an error in Quick View
- [Fix] Elementor deprecated classes and repeater controls errors
- [Fix] Sticky header overlapping admin bar dropdowns
- [Fix] Activate Related Product Slider according to the column number
- [Fix] Load WooCommerce dynamic styles conditionally if they are needed

##### [Version 1.5.2](https://github.com/Codeinwp/neve-pro-addon/compare/v1.5.1...v1.5.2) (2021-04-28)

- [Fix] HTML component does not render shortcodes in Page Header
- [Fix] Color picker inputs from Overlay Color (Blog options) are not bound to the slider
- [Fix] WooBooster - Page scrolls to top when swiping images in Quick view
- [Fix] Sticky add to cart scroll freezing 
- [Fix] WooCommerce Booster breaks the Woocommerce category pages and single product pages if PHP 8.0 is used (Fatal error)
- [Feat] implement next page links for infinite scroll 
- Improve sticky cart behavior by scrolling to form when there are not variations selected

##### [Version 1.5.1](https://github.com/Codeinwp/neve-pro-addon/compare/v1.5.0...v1.5.1) (2021-04-13)

- [Fix] Regression over-escaping for Elementor widgets

#### [Version 1.5.0](https://github.com/Codeinwp/neve-pro-addon/compare/v1.4.3...v1.5.0) (2021-04-12)

- [Fix] Font weight for WooCommerce typography
- [Fix] Blog posts separator toggle not working
- [Fix] Custom Layouts conditional form not appearing
- [Fix] Mobile menu blocked by admin bar when logged in
- [Fix] Show hook names in the Custom Layouts hook selector
- [Fix] Show hook names in the hooks preview mode
- [Fix] Cart side-by-side layout breaking cart notices
- [Feat] Added support for shortcodes in cart notice text
- [Feat] Added WooCommerce products variation swatches
- [Feat] Allow hosting Adobe TypeKit fonts locally
- [Feat] Add WeGlot support in the language switcher header component
- Cart notices UX improvements
- WordPress config for license support

##### [Version 1.4.3](https://github.com/Codeinwp/neve-pro-addon/compare/v1.4.2...v1.4.3) (2021-03-16)

- [Fix] product details duplicated when products shortcode is used in Elementor
- [Fix] custom layouts conditionals not showing in the editor

##### [Version 1.4.2](https://github.com/Codeinwp/neve-pro-addon/compare/v1.4.1...v1.4.2) (2021-03-01)

- [Feat] Adds Elementor widget that displays a custom layout of type individual
- [Feat] Adds the nv-custom-layout shortcode that displays a custom layout of type individual
- [Fix] WooCommerce products results from count when the infinite scroll is enabled not updating
- [Fix] Remove spaces from phone link in the header contact component
- [Fix] Remove product description padding if there is no box shadow for the product

##### [Version 1.4.1](https://github.com/Codeinwp/neve-pro-addon/compare/v1.4.0...v1.4.1) (2021-02-10)

- [Fix] Shop columns CSS gets overridden with Autoptimize on
- [Fix] Elementor editor conflict with Cart Notices
- [Fix] Notices when there are no memberships with LifterMLS
- [Fix] Image coming from {author_avatar} magic tag in Custom Layouts
- [Fix] 404 page created with Custom Layout not translatable with WPML
- [Fix] Custom Layouts not editable with Beaver Builder
- [Feat] New Gutenberg starter sites
- [Fix] Accessibility for scroll to top button
- [Fix] Off-canvas cart inherits site background-color
- [Fix] Recently viewed products not working with Elementor Pro single product templates

#### [Version 1.4.0](https://github.com/Codeinwp/neve-pro-addon/compare/v1.3.2...v1.4.0) (2021-01-18)

- [Feat] Cart notices
- [Fix] PHP editor not working in the Custom Layouts
- [Fix] Whitelabel global color names

##### [Version 1.3.2](https://github.com/Codeinwp/neve-pro-addon/compare/v1.3.1...v1.3.2) (2020-12-21)

- [Fix] Added rel=noopener to Social Sharing links on single post pages
- [Fix] Sticky header scripts not loading in the Customizer
- [Fix] Breadcrumbs for SEOPress and RankMath plugins
- [Fix] Composer requiring PHP greater than 7.1.0
- [Fix] Recently viewed products not working
- [Fix] Sale tag alignment
- [Fix] Add to cart button alignment in the Quick View popup

##### [Version 1.3.1](https://github.com/Codeinwp/neve-pro-addon/compare/v1.3.0...v1.3.1) (2020-12-07)

- [Fix] Compatibility with WP 5.6
- [Fix] Add to cart button for variable products in the Quick View popup

#### [Version 1.3.0](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.12...v1.3.0) (2020-11-24)

- [Feat] New layouts for the Checkout page ( Standard, Vertical, and Stepped )
- [Feat] New CSS and JS methods of loading the Typekit fonts
- [Feat] New option to enable/disable Scroll to top from Customizer
- [Fix] Custom Layouts conditional logic for the Shop page
- New Gutenberg Starter Sites

##### [Version 1.2.12](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.11...v1.2.12) (2020-11-02)

- [Fix] Related products layout
- [Fix] Registered callbacks priorities order for the woocommerce_single_product_summary hook

##### [Version 1.2.11](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.10...v1.2.11) (2020-10-19)

- [Fix] Layout options not applying for the [lifterlms_courses] shortcode
- [Fix] Add to cart button behavior on mobile
- [Fix] Quick view popup overlapping fixed Cart Total box on the Cart page
- [Fix] Overlapping underline style for Elementor links 
- New Gutenberg Starter Sites

##### [Version 1.2.10](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.9...v1.2.10) (2020-10-01)

- [Feat] New Blog layout options
- [Feat] Sticky add to cart
- [Feat] New Header Builder presets in the WooBooster
- [Fix] Custom Layouts compatibility with the Gutenberg plugin
- [Fix] Page Header builder interfering with conditional headers
- [Fix] Color options for the My Account and Wishlist components
- [Fix] Wrong number for WooCommerce orders count when using conditional headers

##### [Version 1.2.9](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.8...v1.2.9) (2020-09-17)

- [Fix] [Elementor Booster] Content Switcher HTML Tag
- [Fix] Icon spacing & border-radius default values in the Social Icons component
- [Fix] Seamless add to cart checked icon not properly aligned
- [Fix] Duplicated CSS rules from the pro modules
- New Gutenberg Starter Sites

##### [Version 1.2.8](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.7...v1.2.8) (2020-09-04)

- [Feat] New Custom Layout component for the Header/Footer Builder ( for Individual Custom Layouts )
- [Fix] Compatibility with WooCoomerce Extra Product Options plugin
- New Gutenberg Starter Sites

##### [Version 1.2.7](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.6...v1.2.7) (2020-08-24)

- [Fix] Compatibility between Custom Layouts and the latest version of Brizy
- [Fix] Make Related Posts images clickable
- [Fix] Hover Opacity control of the Banner Elementor widget
- New Gutenberg Starter Sites

##### [Version 1.2.6](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.5...v1.2.6) (2020-08-04)

- [Feat] Allow HTML tags in the header Contact component
- [Feat] New magic tags for single post pages in Custom Layouts
- [Fix] Compatibility between Elementor Booster and WPML
- [Fix] Layout for the Off canvas cart
- [Fix] Payment Icons component behaviour when WooCommerce Booster is deactivated
- [Fix] Images not visible on the Shop page when Layout is list and Force same image height is checked

##### [Version 1.2.5](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.4...v1.2.5) (2020-07-08)

- [Feat] New options for the Scroll to top module ( image, label, padding, AMP compatibility, accessibility )
- [Feat] Improved layout for the White Label module options
- New Starter Sites
- [Sports Academy](https://themeisle.com/demo/?theme=Sports%20Academy)
- New Gutenberg Starter Sites

##### [Version 1.2.4](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.3...v1.2.4) (2020-06-23)

- [Feat] New typography controls for the Shop and Single Product pages
- [Feat] New layout styles for Categories on the Shop page
- [Feat] New multi-select control to chose the position of the Page Header
- [Feat] Keep infinite scroll state on the Shop page
- [Feat] Refactor LifterLMS customizer controls
- [Feat] Improved licensing mechanism
- [Fix] Buttons not working in the Off-canvas Cart mode
- New Brizy Starter Sites

##### [Version 1.2.3](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.2...v1.2.3) (2020-06-09)

- [Fix] Sticky header on Desktop
- [Fix] Transparent header

##### [Version 1.2.2](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.1...v1.2.2) (2020-06-04)

- [Feat] Responsive sticky header
- [Feat] Color control for the footer Payment Icons component
- [Fix] Transparent header layout while the page is loading
- [Fix] Better handle license validation mechanism
- [Fix] Custom Layouts translatable using Polylang
- [Fix] My Account component layout when using the Gutenberg plugin
- [Fix] Archive Taxonomy and Archive Term conditionals in the Custom Layouts
- [Fix] Icon size control for the Cart icon component
- [Fix] Broken Speed and Video Agency Starter Sites
- [Fix] Turning OFF breadcrumbs was hiding the products filtering and layout toggle on the Shop page
- [Fix] Infinite scroll on categories pages containing subcategories
- [Fix] Page title not updating on the My Account page based on the active subpage
- [Fix] Scroll to top not showing on mobile devices
- New Starter Sites
- [Leather Shop](https://themeisle.com/demo/?theme=Leather%20Shop)
- [Public Notary](https://themeisle.com/demo/?theme=Public%20Notary)
- [Pharmacy](https://themeisle.com/demo/?theme=Pharmacy)
- [Investment Consulting](https://themeisle.com/demo/?theme=Investment%20Consulting)
- New Beaver Builder and Gutenberg Starter Sites

##### [Version 1.2.1](https://github.com/Codeinwp/neve-pro-addon/compare/v1.2.0...v1.2.1) (2020-05-21)

- [Fix] Wrong font-size unit for the My Account component 
- [Fix] Icon color control for the Contact component
- [Fix] Mobile alignment on ordering area on the Shop page
- [Fix] Improved Yoast breadcrumbs appearance mechanism
- New Starter Sites
- [Laundry Services](https://themeisle.com/demo/?theme=Laundry%20Services)
- [Craft Beer](https://themeisle.com/demo/?theme=Craft%20Beer)
- [Gardening](https://themeisle.com/demo/?theme=Gardening)
- [Resume 2](https://themeisle.com/demo/?theme=Resume%202)
- New Beaver Builder and Gutenberg Starter Sites

#### [Version 1.2.0](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.10...v1.2.0) (2020-05-13)

- [Feat] Improved Neve Options page and onboarding experience
- [Fix] Forcing product thumbnails height affects related products
- [Fix] Custom Layouts using the wrong content filter
- [Fix] Certain Typekit fonts not loading
- [Fix] Missing .pot file
- [Fix] Author avatar size on mobile
- [Fix] View Cart button on mobile
- New starter site
- [Copywriter](https://themeisle.com/demo/?theme=Copywriter)
- New Gutenberg and Beaver Builder Starter Sites

##### [Version 1.1.10](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.9...v1.1.10) (2020-04-06)

- [Fix] Force Product Image Height maximum value back to 500px
- [Fix] Infinite scroll on product terms
- [Fix] PHP editor in Custom layouts in WP 5.4
- New Elementor Starter Sites
- New Gutenberg Starter Sites

#### [Version 1.1.9](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.8...v1.1.9) (2020-03-23)

- [Feat] Refactor customizer UI
- [Feat] Add WP-CLI commands for license activation/deactivation
- [Fix] Compatibility issues with PHP 7.4
- [Fix] View Cart position on the Shop page
- [University](https://themeisle.com/demo/?theme=University)
- [Interior Design](https://themeisle.com/demo/?theme=Interior%20Design)
- [Electronics Shop](https://themeisle.com/demo/?theme=Electronics%20Shop)
- [Print Shop](https://themeisle.com/demo/?theme=Print%20Shop)
- [City Tours](https://themeisle.com/demo/?theme=City%20Tours)
- [Insurance](https://themeisle.com/demo/?theme=Insurance)
- [Personal Blog](https://themeisle.com/demo/?theme=Personal%20Blog)
- New Beaver Builder Starter Sites

#### [Version 1.1.8](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.7...v1.1.8) (2020-02-26)

- [Feat] New My Account component in the header builder
- [Feat] Sticky footer
- [Feat] New options for the Cart Icon component: dynamic label, multiple icons and styles
- [Feat] Option for a custom number of columns in the Related Products section
- [Feat] New hooks available in Custom Layouts for the Cart and Checkout pages
- [Fix] Filter products by price when using Infinite Scroll
- [Fix] Sale tag position in the Quick View modal
- [Fix] Warning with Conditional Header when WooCommerce is disabled
- [Scuba Diving](https://themeisle.com/demo/?theme=Scuba%20Diving)
- [Wine Bar](https://themeisle.com/demo/?theme=Wine%20Bar)
- [Mountain Bike Racing](https://themeisle.com/demo/?theme=Mountain%20Bike%20Race)
- [Movie](https://themeisle.com/demo/?theme=Movie%20Showcase)
- [Running Club](https://themeisle.com/demo/?theme=Running%20Club)
- [Jewellery Shop](https://themeisle.com/demo/?theme=Jewellery%20Shop)
- [Car Service](https://themeisle.com/demo/?theme=Car%20Service)
- [Museum](https://themeisle.com/demo/?theme=Museum)
- [Art Exhibition](https://themeisle.com/demo/?theme=Art%20Exhibition)
- [Conference](https://themeisle.com/demo/?theme=Conference)

- New Beaver Builder Starter Sites

#### [Version 1.1.7](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.6...v1.1.7) (2020-02-13)

- [Feat] Extend the transparent header feature for each conditional header
- [Feat] New second menu icon component
- [Fix] Conditional Headers not escaping quotes and slashes for Custom Layouts
- [Fix] Conditional Headers when using a child theme
- [Fix] Conditional Headers buttons when Gutenberg is installed
- [Fix] Product related filters not available in the Custom Layouts

#### [Version 1.1.6](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.5...v1.1.6) (2020-02-03)

- [Feat] New Conditional Headers
- [Feat] New off-canvas sidebar for the Shop page
- [Feat] New image styles for the shop page: Blur, Fade in, Fade out, Glow, Colorize and Grayscale
- [Feat] New payment icons available on the Cart page and in the footer builder
- [Feat] New alignment option for product title and price on the same line on the shop page
- [Feat] New text color and formatting options for the Sale tag on discounted products
- [Feat] New seamless add to cart mechanism for the single product page
- [Fix] Edit Popups in Elementor
- [Fix] Outer Border Top Color applied to all Review Boxes widgets on one page
- [Fix] Buttons alignment in the Flip Card widget
- [Industrial](https://themeisle.com/demo/?theme=Industrial)
- [Adventure](https://themeisle.com/demo/?theme=Adventure)
- [Product Launch](https://themeisle.com/demo/?theme=Product%20Launch)
- [Accounting](https://themeisle.com/demo/?theme=Accounting)
- [Beauty Shop](https://themeisle.com/demo/?theme=Beauty%20Shop)
- [Recruitment Agency](https://themeisle.com/demo/?theme=Recruitment%20Agency)
- [Artist](https://themeisle.com/demo/?theme=Artist)
- [VR Studio](https://themeisle.com/demo/?theme=VR%20Studio)
- [Makeup Artist](https://themeisle.com/demo/?theme=Makeup%20Artist)

- New Beaver Builder Starter Sites
- New Gutenberg Starter Sites

#### [Version 1.1.5](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.4...v1.1.5) (2019-12-19)

- [Fix] JavaScript error with the Flip Card widget

#### [Version 1.1.4](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.3...v1.1.4) (2019-12-19)

- [Feat] Team Member Elementor Widget
- [Feat] Progress Circle Elementor Widget
- [Feat] Banner Elementor Widget
- [Feat] Content Switcher Elementor Widget
- [Feat] Custom Field Elementor Widget
- [Feat] Typography and padding options for the Share Buttons Elementor Widget
- [Feat] Particles for Elementor sections
- [Feat] Animations for Elementor widgets
- [Feat] Content Protection for Elementor widgets
- [Feat] Mobile version for the page header
- [Feat] Color, typography and spacing controls for the Review Box widget
- [Fix] Icons not visible in the Share Buttons widget
- [Fix] Typekit Fonts module not loading fonts
- [Fix] Icons not visible in the Review Box widget when Elementor Pro is activated

- [Fashion Model Agency](https://themeisle.com/demo/?theme=Fashion%20Model%20Agency)
- [IT Technology Agency](https://themeisle.com/demo/?theme=IT%20Technology%20Agency)
- [Christmas Market](https://themeisle.com/demo/?theme=Christmas%20Market)
- [Podcast](https://themeisle.com/demo/?theme=Podcast)
- [Digital Agency](https://themeisle.com/demo/?theme=Digital%20Agency)

- New Beaver Builder Starter Sites

#### [Version 1.1.3](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.2...v1.1.3) (2019-12-05)

- [Feat] New option to hide the Starter Sites Library in the White Label module
- [Feat] Controls for two separate logos in the header builder
- [Feat] New dedicated typography controls for the Contact and Wish List components of the header builder
- [Feat] New dedicated typography controls for the Page header menu and HTML components of the page header builder
- [Blogger](https://themeisle.com/demo/?theme=Blogger)
- [Coupons](https://themeisle.com/demo/?theme=Coupons%20Discounts%20and%20Offers)
- [Escape Room](https://themeisle.com/demo/?theme=Escape%20Room)
- [Wellness Spa](https://themeisle.com/demo/?theme=Wellness%20Spa)
- [Online Courses](https://themeisle.com/demo/?theme=Online%20Courses)
- [Resume](https://themeisle.com/demo/?theme=Resume)

- New Beaver Builder Starter Sites
- New Divi Starter Sites

#### [Version 1.1.2](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.1...v1.1.2) (2019-11-19)

- [Fix] Elementor Pro templates not loading when Related Post was enabled
- [Winery - Wine Shop](https://themeisle.com/demo/?theme=Winery%20-%20Wine%20Shop)
- [News Magazine](https://themeisle.com/demo/?theme=News%20Magazine)
- [Coworking space](https://themeisle.com/demo/?theme=Coworking%20Space)
- [Fishing and Hunting Club](https://themeisle.com/demo/?theme=Fishing%20Hunting%20Club)
- [Car Rental](https://themeisle.com/demo/?theme=Car%20Rental)
- [Ski Resort](https://themeisle.com/demo/?theme=Ski%20Resort%20Winter%20Hotel)
- [Digital Product Funnel](https://themeisle.com/demo/?theme=Digital%20Product%20Funnel)
- [Moving Company Logistics Services](https://themeisle.com/demo/?theme=Moving%20Company%20Logistics%20Services)
- [Translation and Interpreter Services](https://themeisle.com/demo/?theme=Translation%20and%20Interpreter%20Services)

- New Beaver Builder Starter Sites

#### [Version 1.1.1](https://github.com/Codeinwp/neve-pro-addon/compare/v1.1.0...v1.1.1) (2019-11-04)

- [Feat] New color options for the header builder Contact component
- [Feat] New Social icons component for the footer builder
- [Fix] Better explain conditional logic in Custom Layouts
- [Fix] Removed unused page templates in Custom Layouts
- [Fix] Transparent header overriding WP dropdown menus
- [Fix] Missing link on Shop products images
- [Cake Shop](https://themeisle.com/demo/?theme=Cake%20Shop)
- [Transport](https://themeisle.com/demo/?theme=Transport)
- [Speed](https://themeisle.com/demo/?theme=Speed)
- [eBook](https://themeisle.com/demo/?theme=eBook)
- [Food Magazine](https://themeisle.com/demo/?theme=Food%20Magazine)
- [eCourse - Web Design](https://themeisle.com/demo/?theme=eCourse%20Web%20Design)
- [Yoga Studio](https://themeisle.com/demo/?theme=Yoga%20Studio)
- [Sales Funnel](https://themeisle.com/demo/?theme=Crypto%20Sales%20Funnel)
- [Church](https://themeisle.com/demo/?theme=Church)
- [Fashion Magazine](https://themeisle.com/demo/?theme=Fashion%20Magazine)
- New Thrive Architect Starter Sites
- New Beaver Builder Starter Sites
- New Brizy Starter Sites

### v0.0.1 - 2019-01-15 
    **Changes:**
