jQuery(document).ready(function($){

    $('#category-image-select').click(function(e) {
        e.preventDefault();
        let custom_uploader = wp.media({
            title: 'Select category image',
            button: {
                text: 'Select'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            let attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#category-image').val(attachment.id);
            $('#category-image-preview').attr('src', attachment.url);
        });
        custom_uploader.open();
    });

    $('#category-image-remove').click(function(e) {
        e.preventDefault();
        $('#category-image').val('');
        $('#category-image-preview').attr('src', '');
    });

    $('#add_new_section').click(function(e) {
        e.preventDefault();
        let selected_section = $('#select_new_section').val();

        $.ajax({
            url: ajaxurl,
            dataType: 'text',
            method: 'POST',
            data: {
                action: 'get_content_section',
                selected_section: selected_section,
                section_key: get_last_section_key() + 1
            },
            success: function(data) {
                $('.section__content_sections > .repeater-items').append(data);
                let wp_editor_textarea = $(data).find('.wp-editor-area');
                if (wp_editor_textarea.length){
                    console.log(wp_editor_textarea)
                    let wp_editor_textarea_id = $(wp_editor_textarea).attr('id');
                    tinymce.execCommand( 'mceAddEditor', true, wp_editor_textarea_id );
                    quicktags({id : wp_editor_textarea_id});
                    /*tinymce.init(tinyMCEPreInit.mceInit[wp_editor_textarea_id]);*/
                }
            }
        });
    });

    $(document).on('click', '.select-single-image', function(e){
        e.preventDefault();
        let container = $(this).closest('.section-container');
        let custom_uploader = wp.media({
            title: 'Select image',
            button: {
                text: 'Select'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            let attachment = custom_uploader.state().get('selection').first().toJSON();
            $(container).find('input.value-input').val(attachment.id);
            $(container).find('.image-preview img').attr('src', attachment.url);
        });
        custom_uploader.open();
    });

    $('.remove-single-image').click(function(e) {
        e.preventDefault();

        let container = $(this).closest('.section-container');

        $(container).find('input.value-input').val('');
        $(container).find('.image-preview img').attr('src', '');
        $(container).removeClass('isset');
    });

    $(document).on('click', '.select-multiple-image', function(e){
        e.preventDefault();

        let container = $(this).closest('.section-container');
        let current_value = $(container).find('input.value-input').val();

        let custom_uploader = wp.media({
            title: 'Select images',
            button: {
                text: 'Select'
            },
            multiple: true
        });

        custom_uploader.on('select', function() {
            let attachments = custom_uploader.state().get('selection').toJSON();
            let ids = [];
            let urls = [];
            let new_value = [];
            let preview_content = '';

            attachments.forEach(function(attachment) {
                urls.push(attachment.url);
                ids.push(attachment.id);
                preview_content += '<div class="image-preview"><img src="' + attachment.url + '"><button image-id="' + attachment.id + '" class="remove-multiple-image reset button">&times;</button></div>';
            });

            if (current_value) {
                current_value = current_value.split(',')
                new_value = current_value.concat(ids);
            } else {
                new_value = ids;
            }

            new_value = new_value.filter((item, index) => new_value.indexOf(item) === index);

            $(container).find('input.value-input').val(new_value.join(','));
            $(container).find('.image-preview-container').append(preview_content);
        });
        custom_uploader.open();
    });

    $(document).on('click', '.remove-single-image', function(e){
        e.preventDefault();
        let container = $(this).closest('.section-container');

        $(container).find('input.value-input').val('');
        $(container).find('.image-preview img').attr('src', '');
        $(container).removeClass('isset');
    });

    $(document).on('click', '.remove-multiple-image', function(e){
        e.preventDefault();

        let remove_value = $(this).attr('image-id');
        let container = $(this).closest('.section-container');
        let current_value = $(container).find('input.value-input').val().split(',');

        let new_value = current_value.filter(function(item) {
            return item !== remove_value;
        });

        $(container).find('input.value-input').val(new_value);
        $(this).closest('.image-preview').remove();
    });

    $(document).on('click', '.remove-section', function(e){
        e.preventDefault();
        $(this).closest('.section-container').remove();
    });

    $(document).on('click', '.duplicate-section', function(e){
        e.preventDefault();
        let container = $(this).closest('.section-container');
        /*let parent_container = $(container).closest('.inside');*/
        let clone_container = container.clone();

        $(document).find('.section__content_sections .repeater-items').append(clone_container);
        replace_input_key($(clone_container));
    });

    $(document).on('click', '.section-move', function(e) {
        e.preventDefault();
        let container = $(this).closest('.section-container');
        let current_key = parseInt($(container).attr('section-key'));

        if ($(this).hasClass('section-move-up') && $(container).prev().hasClass('section-container')) {
            replace_input_key($(container).prev(), current_key);
            replace_input_key($(container), current_key - 1);
            $(container).prev().before($(container));
        }

        if ($(this).hasClass('section-move-down') && $(container).next().hasClass('section-container')) {
            replace_input_key($(container).next(), current_key);
            replace_input_key($(container), current_key + 1);
            $(container).next().after($(container));
        }
    });

    $(document).on('click', '.item-move', function (e) {
        e.preventDefault();
        let container = $(this).closest('.repeater-item.is-movable');
        if (!container.length){
            return;
        }
        let current_key = parseInt($(container).attr('section-key'));

        if ($(this).hasClass('item-move-up') && $(container).prev().hasClass('is-movable')) {
            replace_input_keys($(container).prev(), current_key);
            replace_input_keys($(container), current_key - 1);
            $(container).prev().before($(container));
        }

        if ($(this).hasClass('item-move-down') && $(container).next().hasClass('is-movable')) {
            replace_input_keys($(container).next(), current_key);
            replace_input_keys($(container), current_key + 1);
            $(container).next().after($(container));
        }
    });

    function replace_input_key(container, key) {
        $(container).attr('section-key', key);
        let inputs = ['input', 'textarea', 'select'];

        inputs.forEach(function (input) {
            $(container).find(input).each(function (index, element) {
                if (!element.hasAttribute('name')) {
                    return true;
                }

                let current_name = $(element).attr('name');

                let new_name = current_name.replace(/(content_sections\[)(\d+)(?=\])/g, (match, p1, p2) => {
                    return p1 + key;
                });

                $(element).attr('name', new_name);
            });
        });
    }

    function replace_input_keys(container, key) {
        if (container.hasClass('permanent-key')){
            return;
        }
        $(container).attr('section-key', key);
        let inputs = ['input', 'textarea', 'select'];

        inputs.forEach(function (input) {
            $(container).find(input).each(function (index, element) {
                if (!element.hasAttribute('name')) {
                    return true;
                }

                let current_name = $(element).attr('name');

                let new_name = current_name.replace(/(\[)(\d+)(?=\])/g, (match, p1, p2) => {
                    return p1 + key;
                });

                $(element).attr('name', new_name);
            });
        });
    }

    function get_repeater_key(repeater_container) {
        let last_item = $(repeater_container).find('.repeater-items .repeater-item:last-child');

        if (last_item.length) {
            let last_key = parseInt(last_item.attr('section-key'));
            if (!isNaN(last_key)) {
                return last_key;
            }
        }

        return 0;
    }

    function get_last_section_key() {
        let last_container = $(document).find('.section__content_sections .repeater-items .section-container:last-child');
        if (last_container.length) {
            let last_key = parseInt(last_container.attr('section-key'));
            if (!isNaN(last_key)) {
                return last_key;
            }
        }
        return 0;
    }

    $(document).on('click', '.section-type__repeater .repeater-add', function (e) {
        e.preventDefault();
        let repeater_container = $(this).closest('.section-type__repeater');
        let section_key = $(repeater_container).attr('section-key');

        console.log(section_key)

        let template = $(repeater_container).attr('template');

        if (!template.length) {
            return;
        }

        $.ajax({
            url: ajaxurl,
            dataType: 'text',
            method: 'POST',
            data: {
                action: 'get_metabox_template',
                template: template,
                section_key: section_key
            },
            success: function (template_html) {
                $(repeater_container).find('.repeater-items').append(template_html);
            }
        });
    });

    $(document).on('click', '.repeater-remove', function () {
        $(this).closest('.repeater-item').remove();
    });

    $(document).on('focus', '.autocomplete', function () {
        let term_type = $(this).attr('term-type');

        $(this).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: ajaxurl,
                    dataType: 'json',
                    data: {
                        action: 'get_data_autocomplete',
                        term: request.term,
                        term_type: term_type

                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui) {
                let container = $(this).closest('.autocomplete-container');
                if (container.length){
                    $(container).find('input').each(function(index, element){
                        let element_key = $(element).attr('data-key');
                        Object.entries(ui.item).forEach(([key, value]) => {
                            if (element_key == key){
                                $(element).val(value);
                            }
                        });
                    });
                }
            }
        });
    });

    $('#suitcasemag-general-settings #reset-settings').on('click', function(e){
        e.preventDefault();
        if (confirm('Are you sure you want to reset all settings?')){
            $.ajax({
                url: ajaxurl,
                dataType: 'json',
                data: {
                    action: 'reset_all_settings'
                },
                success: function (data) {
                    window.location.href = window.location.href + '&settings-reset=true';
                }
            });
        }
    })
});