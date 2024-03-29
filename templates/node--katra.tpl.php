<?php
/**
 * @file
 * Zen theme's implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   - view-mode-[mode]: The view mode, e.g. 'full', 'teaser'...
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 *   The following applies only to viewers who are registered users:
 *   - node-by-viewer: Node is authored by the user currently viewing the page.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $pubdate: Formatted date and time for when the node was published wrapped
 *   in a HTML5 time element.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content. Currently broken; see http://drupal.org/node/823380
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see zen_preprocess_node()
 * @see template_process()
 */
?>

<article class="node-<?php print $node->nid; ?> <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
    <header>
      <?php print render($title_prefix); ?>
      <?php if (!$page && $title): ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($display_submitted): ?>
        <p class="submitted">
          <?php print $user_picture; ?>
          <?php print $submitted; ?>
        </p>
      <?php endif; ?>

      <?php if ($unpublished): ?>
        <p class="unpublished"><?php print t('Unpublished'); ?></p>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <div class="tabbable"> <!-- Only required for left/right tabs -->
    <ul class="nav nav-tabs" id="katra-menu">
      <li class="active"><a href="#code" data-target="#katra-tab-code" data-toggle="tab">code</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          exec<b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#" data-target="#katra-tab-exec" data-toggle="tab">view</a></li>
          <li><a href="#" data-target="#katra-tab-exec" data-toggle="tab" class="katra-run">run</a></li>
        </ul>
      </li>
      <li><a href="#log" data-target="#katra-tab-log" data-toggle="tab">log</a></li>
      <li><a href="#repl" data-target="#katra-tab-repl" data-toggle="tab">repl</a></li>
    </ul>

    <div class="tab-content">
      
      <div class="tab-pane active" id="katra-tab-code">
        <div class="katra-source-panel katra-border">
        <pre id="katra-source" class="katra-source prettyprint"><?php print($content['body']['#items'][0]['value']); ?></pre>
        </div>
      </div>
      
      <div class="tab-pane" id="katra-tab-exec">
        <div class="katra-output-panel katra-border"></div>
        <div class="katra-input-panel katra-border"></div>
      </div>
      
      <div class="tab-pane" id="katra-tab-log">
        <div class="katra-logger-panel katra-border"></div>
      </div>

      <div class="tab-pane" id="katra-tab-repl">
        <div class="katra-repl-panel katra-border"></div>
      </div>

    </div>
  </div>
  
  <script src="../sites/all/themes/d16a/js/lib/jquery-min.js"></script>
  <script src="../sites/all/themes/d16a/js/bootstrap.js"></script>
  <script src="../sites/all/themes/d16a/js/google-code-prettify/prettify.js"></script>
  <script src="../sites/all/themes/d16a/js/lib/json2.js"></script>
  <script src="../sites/all/themes/d16a/js/lib/underscore-min.js"></script>
  <script src="../sites/all/themes/d16a/js/lib/backbone-min.js"></script>
  <script src="../sites/all/themes/d16a/js/lib/jquery.console.js"></script>
  <script src="../sites/all/themes/d16a/js/katra.js"></script>
  
  <?php print render($content['links']); ?>

  <?php print render($content['comments']); ?>

</article><!-- /.node -->
