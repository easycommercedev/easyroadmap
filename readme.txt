=== EasyRoadmap ===
Contributors: easysuite, easycommerce
Tags: roadmap, kanban, product roadmap, feedback
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 0.9
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Build and share your product roadmap with a visual, drag-and-drop Kanban board. Users can view tasks organized by stages and filter by product.

== Description ==

**EasyRoadmap** is a modern WordPress plugin that lets you create, manage, and display product roadmaps in a clean Kanban-style layout.

Tasks are organized into stages (using the custom taxonomy `task_stage`) and can be filtered by product (using `task_product`).

The plugin also supports task voting and exposes data via REST API, making it ideal for transparency, feedback collection, and internal planning.

== Key Features ==

* **Kanban-Style Board:** Easily view and manage tasks by dragging and dropping them across stages.
* **Custom Post Type & Taxonomies:**  
  - `task` post type for roadmap items.  
  - `task_stage` for defining workflow columns (e.g., Planned, In Progress, Done).  
  - `task_product` for categorizing tasks by product.
* **Voting System:** Enable users to upvote or downvote tasks.
* **REST API:** Access and manipulate roadmap data programmatically.
* **Responsive Design:** Fully optimized for both desktop and mobile views.
* **Shortcode Integration:** Use the `[roadmap]` shortcode to embed the roadmap wherever needed.

= Shortcode Usage =

Embed the roadmap on any post or page with:

`[roadmap]`

Optional parameter:
- `product` (integer): Use a term ID from the `task_product` taxonomy to filter tasks. Example: `[roadmap product="12"]`

= Column Color Customization =

Each roadmap stage is a term in the Stages (`task_stage`) taxonomy. To set a custom color for a column:
1. Navigate to **Tasks > Stages** in your WordPress admin.
2. Edit the desired stage (e.g., "Planned", "In Progress").
3. Pick a hex color (e.g., `#3B82F6`) using the color picker
4. The chosen color will appear as the header background for that column on the roadmap board.

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/easyroadmap` directory, or install via the WordPress dashboard.
2. Activate the plugin from the "Plugins" menu.
3. Configure your stages and tasks via the **EasyRoadmap** admin panel.
4. Place the `[roadmap]` shortcode on any page or post to display your roadmap.

== Frequently Asked Questions ==

= Can I filter tasks by product? =
Yes. Use the `product` parameter in the shortcode with a valid term ID from the `task_product` taxonomy.

= Can users vote on tasks? =
Yes, logged-in users can upvote or downvote tasks.

= How do I customize the columns? =
Edit the terms in the `task_stage` taxonomy to change names, order, or assign a custom color.

= Is the plugin developer-friendly? =
Absolutely. EasyRoadmap offers a REST API and clean hooks for customization and extension.

== Screenshots ==

1. Kanban-style roadmap board with drag-and-drop sorting.
2. Task voting interface.
3. Admin panel for task management.
4. Custom color settings for roadmap stages.

== Changelog ==

= 0.9 - 2025.05.27 =
* Initial release with Kanban board, task voting, shortcode support, REST API integration, and customizable taxonomy columns.

== Upgrade Notice ==

= 0.9 =
Initial stable release of EasyRoadmap.
