<div class="repeater-items">
    <?php if (!empty($this->settings['homepage_marquee_posts']) && is_array($this->settings['homepage_marquee_posts'])){
        foreach ($this->settings['homepage_marquee_posts']['ids'] as $key => $id) {
            $post = get_post($id);

            if (!$post){
                continue;
            }

            $item = array(
                'id' => $post->ID,
                'title' => '[' . $post->ID . '] ' . $post->post_title
            );

            $this->get_metabox_template(
                array(
                    'name' => $metabox['repeater_template'] ?? '',
                    'template' => $metabox['repeater_template'] ?? ''
                ),
                $item,
                $key
            );
        }
    } ?>
</div>
<div class="section-options">
    <button class="button button-secondary repeater-add"><?php echo __('Add item', 'suitcasemag-theme'); ?></button>
</div>
