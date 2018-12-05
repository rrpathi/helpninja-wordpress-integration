 <form method="post" enctype="multipart/form-data" action="#" class="">
        <h2>HelpNinja Setup</h2>
        <p>Enter Help Scout API Information below. For details on how to find this information and setting your pages/shortcodes please review the <a href="http://docs.wphelpscout.com/collection/166-help-scout">documention</a>.</p>
        <table class="form-table">
            <tbody>
                 <tr>
                    <th scope="row">Beacon Enable</th>
                    <td>
                        <?php $checked = (get_option( 'ninja_beacon_enable')=='1' ? 'checked' : '') ?>
                        <input type="checkbox"  <?php echo $checked; ?>  id="beacon_enable"  placeholder="" size="40" class="text-input">
                        <p class="description help_block">To locate your API key, login to your Help Scout account and click the <b>User Profile</b> menu in the top-right corner. Visit <b>API Keys</b> and click to <b>Generate an API key</b>.</p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">Beacon ID</th>
                    <td>
                        <input type="text" value="<?php echo get_option( 'ninja_beacon_id');?>"  id="beacon_id"  placeholder="" size="40" class="text-input">
                        <p class="description help_block">To locate your API key, login to your Help Scout account and click the <b>User Profile</b> menu in the top-right corner. Visit <b>API Keys</b> and click to <b>Generate an API key</b>.</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="update_beacon_values" class="button button-primary" value="Save Changes"></p>
</form>