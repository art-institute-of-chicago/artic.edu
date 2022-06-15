Artic.edu Changelog
======================

### 6.35 – Artwork website link + unlisted press releases + beginning to redesign hours

Released April 21, 2022.

#### Added/improved:

- Add artwork website link to artwork pages [WEB-2398]
- Add "is unlisted" option to press releases [WEB-2399]
- Add daily hours fields to CMS [WEB-2356]
- Add dynamic messaging to display hours [WEB-2387]
- Add AIR journal articles to global search [PUB-84]
- Update unit tests to use latest Laravel conventions

#### Fixed:

- Remove /deleted endpoints from website API [WEB-2388]



---

### 6.34 – Performance improvements + artwork type filter + video loop block

Released Feb 24, 2022.

#### Added/improved:

- Add artwork type filter to collection search [ART-50]
- Change order of filters in collection search [ART-50]
- Add support for looped video to video block [WEB-2371]
- Remove Ryerson class visit form [WEB-2377]
- Update names of newsletters [WEB-2384]
- Render setup CSS inline on every page [WEB-2368]
- Disable AJAX transitions between all pages [ART-52]

#### Fixed:

- Fix arrows not appearing on carousels with YouTube embeds [WEB-2379]



---

### 6.33 – Performance improvements

Released Feb 7, 2022.

#### Added/improved:

- Restructure frontend Javascript components so they will only be included where they can be used [WEB-2369]
- Change default ImgIX format from JPG to next generation formats when they are supported by your browser [WEB-2375]
- Remove all unused import commands from Javascript code [WEB-2369]
- Refactor font imports and caching to optimize performance [WEB-2368, WEB-2373, WEB-2374]
- Build out code linting framework [WEB-2364]
- Add highlights to custom "Further Reading" in articles [WEB-2337]
- Add "Research Center" to collection filters [ART-48]
- Show new hours on Visit after midnight Jan 2, 2022 [WEB-2357]
- Update Visit capacity graphic [WEB-2357]
- Add new Vaccination Required icon to options in Visit Page [WEB-2363]
- Move FAQ below CityPASS on Visit [WEB-2362]
- Add `grid` block to articles [WEB-2360]

#### Fixed:

- Fix custom HomeFeatures breaking homepage [WEB-2353, WEB-2335]
- Fix date drift bug on event date rules [WEB-2344]
- Fix close button spacing in disruptor [WEB-2354]



---

### 6.32 – Improvements to events + Laravel/PHP upgrades

Released Nov 16, 2021.

#### Added/improved:

- Increase default number of events to display [WEB-2316]
- Add timezone to iCal events [WEB-2165]
- Add functionality to duplicate events [WEB-2142]
- Update virtual tours hotspot designs [IP-175]
- Add H4 to paragraph block and style it like bold text to fix wonky styling on internship page [WEB-2323]
- Add CityPASS fields back to Visit page [WEB-2319]
- Upgrade to Laravel 8
- Upgrade PHP 7.4

#### Fixed:

- Fix highlight previews [WEB-2330]
- Fix "Explore further" date filter for works created in 2020 [ART-45]



---

### 6.31 – Virtual tours + Journal updates + Laravel and Twill updates

Released Oct 21, 2021.

#### Added/improved:

- Virtual tours: Improve floor hotspots and add alternate style [IP-162, IP-170]
- Virtual tours: Improve carousel to view multiple spaces in one experience [IP-169]
- Add support for HTML tables to the table block [PUB-139]
- Move journal to /artinstitutereview [PUB-148]
- Add Journal to Writings page [PUB-146]
- Update Laravel to version 7
- Update Twill to version 2.5.2
- Update PHP to version 7.3

#### Fixed:

- Fix mobile hero crop functionality [WEB-1542]
- Fix mobile crop in magazine issues [WEB-2317]
- Fix videos not showing in related sidebar [WEB-2318]
- Fix text wrapping and DOI links in footnotes [PUB-137]



---

### 6.30 – Many improvements + structural improvements to open source code

Released Oct 7, 2021.

#### Added/improved:

- Add hero crop for mobile [WEB-1542]
- Update video blocks to Vimeo videos behave like YouTube videos [WEB-2287]
- Add schema.org to blog articles [WEB-2274]
- Improve transition and scrolling behavior in interactive features [IP-105, IP-48]
- Add support for animated GIFs in interactive features [IP-7]
- Remove translation models and tables [WEB-2201]
- Remove old `gallery` and `artworks` blocks as they've been replaced with a move flexible combined block [WEB-2207]
- Delete reference to Bon Appetit from Event Planning form [WEB-2315]
- Add `size` field to 360 Embeds [PUB-138]
- Support tables in AIR [PUB-139]
- Add superscript to paragraph block [PUB-143]
- Add social metadata override fields to journal and digital publications [PUB-145]

#### Fixed:

- Add italics and link formatting options back to artist and department forms [WEB-2283]
- Fix manual credits not saving on interactive feature slides [IP-145]
- Fix hotspots being blocked by other content in interactive features [IP-109]
- Fix visibility of unlisted content [WEB-2290]
- Prevent footnote arrows from breaking lines [PUB-137]
- Prevent superscript from breaking line heights [PUB-142]
- Fix bold serif formatting for publication content [PUB-140]

#### Code/structural improvements:

- Move email list parameters to a non-repo config file [WEB-2212]
- Cleanup unused code [WEB-2205, WEB-2184, WEB-2189, WEB-2201, WEB-2172, WEB-2187, WEB-2198, WEB-2291, IP-148]
- Improve code comments [WEB-2252]
- Improve implementation of our custom helper functions [WEB-2299]
- Change Laravel helper functions to `Str::` and `Arr::` calls [WEB-2204]
- Format README with AIC template and add code LICENSE [WEB-2192]
- Add licensing info to code from other projects we use [WEB-2194]
- Remove code that doesn't have an open license [WEB-2249]
- Improve documentation [WEB-2192]
- Upgrade to Composer 2 [WEB-2217]
- Upgrade to Laravel 6 [WEB-2294]
- Update SASS compiler [WEB-2314]



---

### 6.29 – Update Twill + AIR development + open source website preparations

Released Aug 31, 2021.

#### Added/improved:

- Upgrade to latest version of Twill [WEB-1531, WEB-1788, WEB-1849, WEB-1877, WEB-2087, WEB-2089, WEB-2092–6, WEB-2124, WEB-2148, WEB-2159, WEB-2213, WEB-2221–3, WEB-2229]
- Add carousel to virtual tours [IP-143, IP-146]
- Final updates to Art Institute Review [PUB-125–32, WEB-2275]
- Begin code improvements to open source website [WEB-2098, WEB-2173, WEB-2177, WEB-2180, WEB-2182–5, WEB-2188, WEB-2191, WEB-2195, WEB-2197, WEB-2199, WEB-2200, WEB-2203, WEB-2213, WEB-2252]
- Create native audio player block [WEB-2215]
- Add strikethrough formatting option to fields in the CMS [WEB-2283]
- Add GA tracking events content [WEB-2216, WEB-2225]
- Remove Select Language menu on Visit page [WEB-2174]
- Update hours on visit page [WEB-2175, WEB-2284]
- Show wait times on small breakpoint [WEB-2164]
- Hide wait times when the museum is closed [WEB-2164]
- Add asterisks to required fields on forms [WEB-1463]
- Clean some bad characters that get copy-pasted from Word [WEB-2098]
- Improve image downscaling in Chrome and Firefox [IMG-37]
- Add "2020" to collection date filter [ART-43]

#### Fixed:

- Fix bug preventing Interactive Features from being added as related content on Dept Pages [WEB-2153]
- Fix bugs preventing users from updating featured IFs [WEB-2211]
- Fix incorrect link on Authors Listing sidebar [WEB-2170]
- Fix sitemap generation during deployment [WEB-2218]
- Fix Magazine using exhibition title from 'Title Formatting' field [WEB-2230]



---

### 6.28 – Virtual tours, wait times and digital journal

Released Jun 21, 2021.

#### Added/improved:

- Final UI updates to virtual tours
- Transition live wait times from QLess to Qudini
- Add new Malangatana functionality to AIR digital journals
- Allow Tableau Public Embeds in Media Block [WEB-2155]
- Add additional blocks to Highlights pages [WEB-2156]
- Make digital journal issues available in the production CMS [WEB-1486]

#### Fixed:

- Properly display italics on generic pages [WEB-2143]
- Fix issue with Experience Image slides not updating credits from data hub [IP-128]



---

### 6.27 – Virtual tours + support for Obama portraits exhibition

Released May 19, 2021.

#### Added/improved:

- Additions to virtual tours [IP-89, IP-93, IP-94, IP-95, IP-97]
- Add Feature 2x block to support Obama content [WEB-2075]
- Add Feature 4x block to support Obama content [WEB-2076]
- Add end credits to primary layout in interactive features [IP-107]
- Add anchor tags to all headings across entire website [WEB-2111]
- Add digital publication sections to global search, for when Malangatana goes live [PUB-5]
- Add text about closed days to Educator Admission Request form [WEB-2115]
- Add H4 tag to accordion items to let content folks add anchor links to each question in the FAQ [WEB-1783]
- Add custom text to override wait times [WEB-2140]
- Remove "Evening Associates" from the Event Type list [WEB-1981]

#### Fixed:

- Fix for Zoom events: show an event in the listing if it has already started and it's the only event of the day [WEB-1974]
- Fix issue with saving experience images with no inline credits [IP-91]
- Disable sticky header on Interactive Features [WEB-2108]
- Fix logical error that threw an error on Ryerson and Burnham Libraries department page [WEB-2137]
- Fix date filter in "Explore Further" for living artists [WEB-2112]
- Fix Gallery block: Disable buttons when carousel is too wide to scroll [WEB-2113]
- Put maximum length on artwork URLs, so ones like [this](https://www.artic.edu/artworks/182408/model-1964-renault-dauphine-four-r-1095-body-type-seating-4-dr-sedan-4-to-5-persons-engine-type-14-52-weight-1397-lbs-price-1495-00-usd-original-engine-data-base-four-inline-overhead-valve-four-cylinder-cast-iron-block-and-aluminum-head-w-removable-cylinder-sleeves-displacement-51-5-cu-in-845-oc-bore-and-stroke-2-28-x-3-15-in-58-x-80-mm-compression-ration-7-25-1-brake-horsepower-32-sae-at-4200-rpm-torque-50-lbs-at-2000-rpm-three-main-bearings-solid-valve) don't break [WEB-1956]



---

### 6.26 – Digital publications + Related sidebar

Released Apr 27, 2021.

- Refine platform for digital publications on the website, including [PUB-40, PUB-31]
- Show related content where artwork was featured in blocks in its sidebar [WEB-2027]
- Show recent content in sidebar on artwork pages when there is no related content [WEB-2026]
- Updates to virtual tour platform [WEB-2011]
- Optimize artwork image sizes to prevent upscaling [WEB-1880]
- Update website integration with shop products [WEB-2007]
- Fix bug affecting updating CITI fields on interactive feature images [WEB-2056]



---

### 6.25 – Digital publications + Mirador kiosk viewer

Released Mar 16, 2021.

- Create a platform for digital publications on the website
- Create kiosk-version of Mirador book viewer [WEB-1951]
- Support HTML tables in CITI Styled Web Descriptions [WEB-1972]
- Add a dividing line to Image Slider block [WEB-1958]
- Remove `is_boosted` from articles [WEB-1953]
- Allow greater control over the content in Further Reading for magazine articles [WEB-1975]
- Remove end-screen credits tooltip when there are no credits in Interactive Features [WEB-1990]



---

### 6.24 – Bug fixes

Released Feb 16, 2021.

- Fix expired events showing up in magazine event block [WEB-1928]
- Fix preview links for some page types that use ImgIX [WEB-1796]
- Fix preview links for educator resources [WEB-1796]
- Add loader indicator between pages in Mirador viewer [WEB-1921]
- Preserve order of image assets as they're set in CITI [WEB-1926]
- List authors alphabetically by last name [WEB-1927]
- Fix parsing of footnote shortcode tags [WEB-1930]
- Add citation to digital journal articles [WEB-1135]
- Final cleanup of generated PDF for digital journal [WEB-1595]
- Add Zotero integration to blog articles, AIR articles and artwork pages [WEB-1129, WEB-173, WEB-174]
- Add `nocache` param to cache-bust API responses [WEB-1919]



---

### 6.23 – Mirador, Winter Magazine support + virtual events

Released Jan 26, 2021.

- Show on-loan status on artwork pages [WEB-1910]
- Create standalone virtual tour page
- Ongoing development on virtual tour experience
- Add ability to use Mirador on exhibition pages [WEB-1820]
- Add ability to use 360°s, image slider and Mirador on journal articles [WEB-1913]
- Add ability to modify visit button text on homepage [WEB-1890]
- Add ability to hide hours on Visit page [WEB-1891]
- Hide exhibitions titlebar on homepage when none are selected [WEB-1890]
- Finish sidebar for Digital Journal issues [WEB-1852]
- Enable and touch up paragraph numbers in journal articles [WEB-1607]
- Fix figure numbers in journal articles [WEB-1607, WEB-1913]
- Fix social preview in journal articles [WEB-1914]
- Add note to paragraph blocks about how to add footnotes [WEB-1131]
- Update logic that generates a PDF after saving an article [WEB-1599]
- Link authors in the sidebar to author pages [WEB-1884]
- Add IIIF Manifest URL to artwork pages [WEB-1922]
- Fix preview mode in exhibitions [WEB-1796]
- Centralize canonical redirect logic [WEB-1888]



---

### 6.22 – Mirador, Winter Magazine support + virtual events

Released Oct 28, 2020.

- Final QA for Mirador article blocks [WEB-WEB-1844]
- Add new virtual event fields to CMS [WEB-1865]
- Add first/given names to artist block on home page [WEB-1866]
- Hide unlisted articles from RSS feed
- Fix disruptor banner so it will stay closed for 24 hours after a user closes it [WEB-1692]
- Add option to use white for pillar boxing images [WEB-1871]
- Changin heading text in articles to accommodate full length [WEB-1857]
- Fix bug related to CMS preview function [WEB-1296, WEB-1875]
- Update capacity graphic to reflect hours change [WEB-1842]



---

### 6.21 – New hours and updated department names + add image slider and Mirador blocks

Released Oct 12, 2020.

- Update hours on visit page [WEB-1842]
- Update department names in collections search [WEB-1831]
- Readd events on home page [WEB-1848]
- Update logic for Exhibition "Closing Soon" tag to honor web overrides [WEB-1836]
- Only show wait times on exhibition pages while the exhibition is open [WEB-1841]
- Reduce cache times for wait times [WEB-1854]
- Add new image slider block [WEB-83]
- Add the ability to present artworks with a Mirador viewer on artwork pages and via a new block [WEB-1820, WEB-1843, WEB-1844, WEB-1814]
- Finish styling of generated print PDFs for digital journal [WEB-1595]
- Regenerate PDFs each time published content is updated [WEB-1596]
- Continue development on the static sidebar for digital journals [WEB-1838, WEB-1549]



---

### 6.20 – Rename Sustaining Fellows, support using web exhibition dates in public API

Released Sep 15, 2020.

- Update all references to "Sustaining Fellows" to "Luminary" [WEB-1825]
- Updates to support exhibitions in public API using web dates instead of CITI dates [WEB-1822]
- Remove deprecated lightbox options in the CMS form [WEB-1818]
- Preload font CSS files to improve page load performance [WEB-1821]
- Update Learn with us and Support us mobile nav links [WEB-1824]
- Lint block vues



---

### 6.19 – Final push for magazine support + 3D tour updates

Released Aug 13, 2020.

- Display 3D tour loading message [WEB-1794]
- Add option to hide annotation title for 3D tour block and 3D tour slide for IFs [WEB-1793]
- Add ability to attach sponsors to articles [WEB-1787]
- Update static text in magazine footer with link to sponsors [WEB-1784]
- Hide unlisted articles from "Further reading" [WEB-1667]
- Add "Also in this issue" to welcome note [WEB-1791]
- Add checkbox to display large and medium images in full [WEB-1792]
- Fix italics wrap in "Audio Tour Block" titles [WEB-1785]
- Address minor bugs related to Twill update to 1.2.2 [WEB-1788]



---

### 6.18 – Wait time updates, captions and more + Magazine updates

Released Aug 5, 2020.

- Don't show wait times on Tuesdays and Wednesdays [WEB-1780]
- Add Member wait times to current GA wait times on exhibition pages [WEB-1775]
- Add ability to add additional text below tombstone caption of artworks blocks [WEB-1779]
- Add the ability to caption hours image on Visit page [WEB-1761]
- Add Recently Viewed back to artist and department pages [WEB-1759]
- Update 'Visit us online' button on the homepage to just say 'Visit'
- Hide upcoming events on exhibition pages when empty
- Upgrade to Twill 1.2.2 [WEB-1782]

#### Magazine updates:

- Adjust hero image crop on magazine [WEB-1772]
- Rename "Welcome Note" to "To Our Community" [WEB-1774]
- Add ability to override welcome note author [WEB-1774]
- Prioritize showing list of related author entities over author display [WEB-1771]
- Add ability to override title of Audio Tour Stop blocks [WEB-1785]
- Add option to hide promo text in Tour Stop audio blocks [WEB-1777]
- Use `subtype` for articles in "Also in this issue" [WEB-1774]
- Updates to GTM events on magazine and homepage [WEB-1764]



---

### 6.17 – Capacity and wait times + Magazine updates

Released Jul 27, 2020.

- Add capacity information to Visit page [WEB-1729]
- Add real-time wait time information to exhibition pages [WEB-1763]
- Create artic.edu/today redirect for ticket sales [WEB-1746]
- Extend Recently Viewed history time to two weeks [WEB-1754]

#### Magazine:

- Show article type as tag for magazine article cards [WEB-1736]
- Make author images on author details pages black and white [WEB-1714]
- Properly display welcome note in page previews [WEB-1748]
- Update GTM events on Magazine issue pages [WEB-1755]
- Rely on the website's exhibition date overrides when displaying exhibition information [WEB-1749]
- Hide unlisted content from search engines [WEB-1757]
- Add program selector to magazine events block [WEB-1758]

#### More updates:

- Consolidate Image Gallery block and Artworks blocks to a new single block [WEB-1251]
- Fix issue with new SVG images not appearing for some users [WEB-1702]
- Abbreviate visit subheadings in CMS navigation [WEB-1729]



---

### 6.16 – Update Visit page to prepare for the reopening + magazine

Released Jul 15, 2020.

- Lots of updates Visit page [WEB-1732]
- Add exhibitions back to the homepage [WEB-1750]
- Rename "Artists" in global search to "Artists/Cultures" [WEB-1705]
- Make caption under the image on artist pages WYSIWYG with the ability to add links [WEB-1712]
- Add 360° block to exhibition pages [WEB-1737]
- Visual QA updates to magazine [WEB-1714]
- Add GTM event tags to magazine [WEB-1717]
- Correct GTM event tags on homepage [WEB-1716]
- Fix hyperlink styling on Windows Edge [WEB-643]



---

### 6.15 – Performance improvements

Released Jun 23, 2020.

- Add classification to Explore Further on Artist pages
- Check if content is set before showing sections on homepage [WEB-1707]
- On artist pages, get all attributes needed for artworks from search response, not from a subsequent /artworks call [WEB-1292, WEB-1515]
- Only call place_pivots and dates on artwork queries where they are used [WEB-1292, WEB-1515]
- Take catalogues_pivots off of artwork queries except where it's used [WEB-1292, WEB-1515]
- Put in condition on homepage to account for artists being unpublished
- Correct link to slides from experiences in CMSFix issue with creating new experiences without a grouping



---

### 6.14 – Digital Magazine + 360° blocks

Released Jun 11, 2020.

- Add 360° viewer functionality to block editors [WEB-1693, WEB-1694]
- Create space for online Member Magazine based on Digital Journal work [WEB-1688]
- Add the ability to publish, but unlist, Articles, Highlights and Experiences [WEB-1667]
- Create Author pages, which show Articles, Highlights, and Experiences written a given person [WEB-1686]
- Add "Also in this Issue" blocks to unlisted Articles, Highlights and Experiences [WEB-1679]
- Add GTM tagging to homepage [WEB-1690]
- Correct pagination logic when a user reaches the end of page list [WEB-1665]



---

### 6.13 – Redesigned homepage + 360° spins on artwork pages + many other improvements

Released May 26, 2020.

- Redesign homepage to highlight more of our digital content
- Add 360° viewer option to artwork pages [WEB-155]
- Allow users to close the closure banner [WEB-1637]
- Add Highlights to global search [WEB-1640]
- Add Highlights listing page [WEB-1655]
- Create single CMS listing all experiences and allow sorting [WEB-1613]
- Change "BC" to "BCE" on historic dates [WEB-1642]
- Correct font size issue on Interactive Features listing [WEB-1611]
- Minor adjustments to Digital Journal frontend
- Finish basic print-to-PDF functionality [WEB-1595]



---

### 6.12 – Deep zoom images + exhibition date overrides + video detail pages

Released Apr 27, 2020.

- Add newsletter signup variation to promo slider [WEB-1629]
- Add block editor to video pages [WEB-1630]
- Add date display override to exhibitions to customize dates text [WEB-1632]
- Improve the video detail page [WEB-1635]
- Show image-specific credit line on artwork images [WEB-1628]
- Provide the ability to upload larger-sized images for artworks [WEB-1631]
- Use hero images of interactive features on social media [WEB-1509]



---

### 6.11 – Redesign lightboxes + additional improvements

Released Apr 15, 2020.

- Redesign modal lightbox to a footer slider [WEB-1598]
- Add ability to show up to three related contents in the right sidebar [WEB-1625]
- Remove hours header element if the text is empty
- Set cursor focus back on search icon when closing global search modal [WEB-1455]
- Properly display WYSIWYG listing description content for interactive features [WEB-1564]



---

### 6.10 – Accessibility updates

Released Apr 8, 2020.

- A number of small fixes to help the website pass HTML validation, which is a basic for web accessibility. [WEB-1449] Includes:
  - Account for quotes in JSON-LD on homepage
  - Remove errant `<div>` from being displayed in <head>
  - Change elements to `<div>`s which have child `<p>` tags. A result for converting a number of CMS fields to WYSIWYG over the past year.
  - Refactor srcset sizes so they don't end with a stray comma
  - Remove duplication of DOM ids when share icons are shown more than once on a page
  - Put in a filler image to the fullscreen placeholder for when it's not used
- Fix published check on artwork and artist admin [WEB-1623]
- Fix default CMS preview functionality that broke with new preview links [WEB-1296]



---

### 6.9 – Preview links

Released Apr 6, 2020.

- Add a preview link to all unpublished CMS content [WEB-1296]
- Add italics to listing description for interactive feature experiences [WEB-1564]
- Disable AJAX transitions on links to educational assets [WEB-1612, WEB-1119]



---

### 6.8 – Build out Digital Journal Issue page + support virtual visit pages

Released Apr 1, 2020.

- Update "Plan your visit" links to "Visit us virtually" [WEB-1590]
- Improve caching of AWS IP addresses [WEB-1604]
- Add image link to split block module [WEB-1605]
- Initial integration of Prince XML PDF generation [WEB-1489]
- Hide NOW OPEN text on exhibitions when there is an active closure [WEB-1592]
- Build out editor's note and article tiles on digital journal issue page [WEB-1140]
- Update canceled events to ensure uniformity in how the "CANCELED | " prefix is added [WEB-1602, WEB-1603]
- Reorder Event admin fields [WEB-1586]
- Disable AJAX transitions when opening Interactive Features [WEB-1609, WEB-1119]



---

### 6.7 – Updates to support COVID-19 announcements + other minor improvements

Released Mar 19, 2020.

- Move closure notice above header [WEB-1580]
- Remove exhibitions from homepage during COVID-19 closure [WEB-1571]
- Fix related content on exhibition detail pages [WEB-1565]
- Improve reordering algorithm for generic pages [WEB-1576]
- Update Interactive Features frontend package



---

### 6.6 – Final development for interactive features and updates to support COVID-19 announcements

Released Mar 16, 2020.

- Enable /interactive-features listing [WEB-1557]
- Show descriptions on /interactive-features [WEB-1561]
- Hide Interactive Features from Articles landing if none are published [WEB-1557]
- Fix thumbnail crop for Interactive Features to 16:9 [WEB-1561]
- Make Interactive Features description multi-row in CMS [WEB-1561]
- Fix captions in Interactive Feature compare module [WEB-1573]
- Update Interactive Feature frontend package
- Limit automatically generated related content in articles to only published articles [WEB-1552]
- Add the ability to provide links in Closure copy [WEB-1569]
- Remove events from homepage during COVID-19 closure
- Update links in Support Us in the footer



---

### 6.5 – Prepare for interactive features launch and other minor improvements

Released Mar 5, 2020.

- Updates to the availability of interactive features in preparation for the launch [WEB-1557]
- Update to interactive features display on social [WEB-1509, WEB-1561]
- Show CITI place information on artist pages [WEB-150]
- Add "nofollow" and "noindex" to past event pages [WEB-1556]
- Add default content to "Further Reading" on article pages [WEB-1552]
- Support refresh of ticketed event staging database [WEB-1558]



---

### 6.4 – Front end performance and CMS improvements

Released Feb 25, 2020.

- Enable a dashboard of the CMS
- Fix bug when saving experience images with no inline credits [WEB-1520]
- Only clear the website cache for entities that have been published [WEB-1364]
- Finish optimizations for improving print styles [WEB-289]
- Update Interactive Features frontend package



---

### 6.3 – Minor improvements

Released Feb 20, 2020.

- Fix modal behavior on image galleries which caused images to be zoomed in [WEB-1523]
- Document all the fields are used from the API on a given page, as a measure towards improving performance [WEB-119]
- Initial work to improve print styles [WEB-289]
- In newsletter signup, rename OptAcademicEngagement label to "Research, Publishing, and Conservation" [WEB-1530]
- For Interactive Features, populate in-line credit information from the Data Hub [WEB-1520]
- Update Interactive Features frontend package



---

### 6.2.1 – Adjust artwork cropping functionality

Released Feb 11, 2020.

- Ensure that artwork thumbnails never get cropped in pinboards (collection search, artist pages, explore further, etc.) [WEB-1495]
- Add `/journal` page to publication navigation (if that page is published) for the Art Institute Review [WEB-1522]



---

### 6.2 – Continued work on digital journals, minor improvements to frontend

Released Feb 10, 2020.

- Add strikethrough formatting option to paragraph blocks [WEB-1525]
- For artist page social images, use either artist image or image of first artwork [WEB-1420]
- Add `author` entity that can be linked to journal articles as well as blog articles [WEB-1511]
- Add ability to display linkable paragraph numbers in journal articles [WEB-1136]
- Add ability to display figure numbers on all media-related blocks [WEB-1133]
- Hide figure and paragraph numbers in production [WEB-1133, WEB-1136]
- Have issue articles only publish if the related issue is published [WEB-1484]
- Move publication sidebar navigation to helper [WEB-1522]
- Remove excessive share buttons [WEB-1137]
- Remove obsolete code from views related to speakers and comments



---

### 6.1 – Minor frontend enhancements, continuing work on digital journal CMS

Released Jan 21, 2020.

- Set up a nightly job to automatically update links in the CMS that reference the admin or CDN [WEB-1505]
- Don't show skrim that blocks out content if the lightbox is empty [WEB-1499]
- Update object detail page disclaimer [WEB-1497]
- Avoid showing a single item in left-column navigation [WEB-1467]
- Add Date Qualifiers to Web Basic artworks [WEB-1494]
- Improve integration between journal issues and articles in CMS [WEB-1486]



---

### 6.0 – Minor enhancements, begin work on digital journal

Released Jan 13, 2020.

- Fix website API behavior when database gets reimported [WEB-1315]
- Begin digital journal CMS buildout (hidden in production) [WEB-1485, WEB-1486]
- Update digital labels UI package



---

### 6.0-beta56 – Updates for Interactive Features

Released Jan 2, 2020.

- Increase text length limits of Interactive Feature fields [WEB-1471, WEB-1473]
- Make some Interactive Feature fields WYSIWYG [WEB-1473]
- Increase the number of images that can be used in a modal on Interactive Features slides [WEB-1477]
- Remove Interactive Features from global search results in production [WEB-1478]
- Remove unused caption field [WEB-1476]
- Update Digital Labels UI package



---

### 6.0-beta55 – Add 3D integration and work towards sending test emails

Released Dec 20, 2019.

- Add ability to integrate 3D models into various pages
- Hide 3D model options from production CMS
- Add triggers for sending test emails in third-party systems [WEB-1445]



---

### 6.0-beta54 – Improvements to unsubscribe, scheduling hours changes and related items

Released Dec 10, 2019.

- Correct unsubscribe behavior when user is not in our email list [WEB-1427]
- Clean up error reporting that was being used for long-term logging [WEB-1426]
- Correct scheduling logic of hours changes [WEB-1443]
- Refactor 'related items' in right sidebar [WEB-1415]



---

### 6.0-beta53 – Improvements to image and data display, minor enhancements

Released Nov 25, 2019.

- Fix artwork blur due to percentile transform translate [WEB-1338]
- Always use `title` from API for augmented models [WEB-1315]
- Fix apostrophe getting encoded in lefthand menu [WEB-1386]
- Fix Explore Further in artist pages that were not showing artworks due to no death date on the artist record [WEB-1402]
