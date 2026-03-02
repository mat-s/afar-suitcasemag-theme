<?php
// Spalte hinzufügen
add_filter('manage_post_posts_columns', function ($columns) {
  $new_columns = [];
  foreach ($columns as $key => $value) {
    $new_columns[$key] = $value;
    if ($key === 'title') {
      $new_columns['template_type'] = __('Template Type', 'suitcasemag-theme');
    }
  }
  return $new_columns;
});

// Spalteninhalt füllen
add_action('manage_post_posts_custom_column', function ($column, $post_id) {
  if ($column === 'template_type') {
    
    $post_meta = get_post_meta($post_id);
    $isTemplateUsagePresent = is_array($post_meta)
    && array_key_exists('template_usage', $post_meta)
    && is_array($post_meta['template_usage'])
    && count($post_meta['template_usage']) > 0;
    
    $templateVariant = 'not_set';

    if ($isTemplateUsagePresent) {
      $templateVariant = $post_meta['template_usage'][0];
    }

    $color = match ($templateVariant) {
      'old_variant' => '#fd434b',
      'new_variant' => '#92c9a8',
      default => '#fdba21',
    };

    $label = match ($templateVariant) {
      'old_variant' => 'Old',
      'new_variant' => 'New',
      'not_set' => 'Unset',
      default => $templateVariant,
    };

    echo '<span style="background-color:' . esc_attr($color) . '; color: white; padding: 2px 10px 4px; border-radius: 20px;">' . esc_html($label) . '</span>';
  }
}, 10, 2);

// Spalte sortierbar machen
add_filter('manage_edit-post_sortable_columns', function ($columns) {
  $columns['template_type'] = 'template_type';
  return $columns;
});

// Sortierlogik definieren
add_action('pre_get_posts', function ($query) {
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  $orderby = $query->get('orderby');
  if ($orderby === 'template_type') {
    $query->set('meta_key', 'template_usage');
    $query->set('orderby', 'meta_value');
  }
});

// Filter-Dropdown für Template Type hinzufügen
add_action('restrict_manage_posts', function () {
  global $typenow;
  if ($typenow !== 'post') {
    return;
  }

  $selected = $_GET['template_type_filter'] ?? '';
  ?>
  <select name="template_type_filter">
    <option value=""><?php _e('All Template Types', 'suitcasemag-theme'); ?></option>
    <option value="old_variant" <?php selected($selected, 'old_variant'); ?>><?php _e('Old', 'suitcasemag-theme'); ?></option>
    <option value="new_variant" <?php selected($selected, 'new_variant'); ?>><?php _e('New', 'suitcasemag-theme'); ?></option>
    <option value="not_set" <?php selected($selected, 'not_set'); ?>><?php _e('Unset', 'suitcasemag-theme'); ?></option>
  </select>
  <?php
});

// Query anhand des Filters anpassen
add_filter('pre_get_posts', function ($query) {
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  if (isset($_GET['template_type_filter']) && $_GET['template_type_filter'] !== '') {
    $filter = sanitize_text_field($_GET['template_type_filter']);
    if ($filter === 'not_set') {
      $query->set('meta_query', [
        [
          'key' => 'template_usage',
          'compare' => 'NOT EXISTS',
        ]
      ]);
    } else {
      $query->set('meta_query', [
        [
          'key' => 'template_usage',
          'value' => $filter,
          'compare' => 'LIKE',
        ]
      ]);
    }
  }
});
