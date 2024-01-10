<?php
$link_text = get_post_meta($post->ID, 'borsay_slider_link_text', true);
$link_url = get_post_meta($post->ID, 'borsay_slider_link_url', true);

?><table class="form-table borsay-slider-metabox">
    <input type="hidden" name="borsay_slider_nonce" value="<?php echo wp_create_nonce("borsay_slider_nonce"); ?>" >

    <tr>
        <th>
            <label for="borsay_slider_link_text">Link Text</label>
        </th>
        <td>
            <input
                type="text"
                name="borsay_slider_link_text"
                id="borsay_slider_link_text"
                class="regular-text link-text"
                value="<?php echo ( isset($link_text)) ?  esc_html($link_text) : ''; ?>"

                >
        </td>
    </tr>
    <tr>
        <th>
            <label for="borsay_slider_link_url">Link URL</label>
        </th>
        <td>
            <input
                type="url"
                name="borsay_slider_link_url"
                id="borsay_slider_link_url"
                class="regular-text link-url"
                value="<?php echo($link_url == '#' || !isset($link_url)) ? '' : esc_url($link_url); ?>"

                >
        </td>
    </tr>
</table>

