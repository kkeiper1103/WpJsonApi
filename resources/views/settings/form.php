<?php $this->layout("layout", ["title" => $title]) ?>

<p>Here, you can set some settings for the JSON API Plugin. Currently, it only supports setting the Auth Key.</p>

<form action="<?= get_admin_url(null, "options-general.php?page=wp-json-api") ?>" method="post">
    <?php wp_nonce_field('json_api_settings') ?>

    <table class="form-table">
        <tbody>

        <tr>
            <th scope="row">
                <label for="settings_required">Authorization Required?</label>
            </th>
            <td>
                <input type="hidden" name="settings[required]" value="0">
                <input type="checkbox" name="settings[required]" id="settings_required"
                       value="1" <?= ($settings->get("required", false) == false) ?: "checked" ?> />
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="settings_key">API Key</label>
            </th>
            <td>
                <input type="text" name="settings[key]" id="settings_key"
                       class="medium-text" value="<?= $settings->get("key", md5(mt_rand())) ?>" />
                <p class="description">If Authorization is Required, include this value in your headers as '<strong>X-WPJSONAPI-AUTH</strong>'</p>
            </td>
        </tr>

        <tr>
            <th scope="row">
                <label for="settings_prefix">API Prefix</label>
            </th>
            <td>
                <input type="text" name="settings[prefix]" id="settings_prefix"
                       class="medium-text" value="<?= $settings->get("prefix", "api") ?>" />
                <p class="description">Prefix for the API. (defaults to "api")</p>
            </td>
        </tr>

        </tbody>
    </table>

    <button class="button button-primary">Submit</button>
</form>