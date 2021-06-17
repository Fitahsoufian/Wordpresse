<?php

/*
Plugin Name: change_text
Plugin URI: 
Description: plugin for changing text title .
Author: Abdessamad Souilem & Soufiane fitah
Author URI: 
Version: 0.1
*/


add_action('admin_menu', 'change_text_admin_action');
function Change_text_admin_action()
{
    
    add_menu_page( 'change_text', 'change_text', 'manage_options', 'change_text', 'change_text_admin', 99 );
}

function change_text_admin()
{
    global $wpdb;
    $mytestdrafts = array();
    $mytestdrafts_id = $_GET['id'];
    if ($mytestdrafts_id) {
        echo $mytestdrafts_id;
        include_once("updaterecords.php");
    } else {
        ?>
        <div class="wrap">
            <h4>Edit post title Plugin</h4>
            </br>
            <br/>
            <form action="" method="POST">
                <input type="submit" name="search_all_post" value="Load all Post" class="button-primary"/>

                <br/>
                <table class="widefat">
                    <thead>
                    <tr>
                        <th> Post Title</th>
                        <th> Post ID</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th> Post Title</th>
                        <th> Post ID</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php

                    if (isset($_POST['search_all_post'])) {

                        $mytestdrafts = $wpdb->get_results(
                            "
                SELECT ID, post_title
                FROM $wpdb->posts
                WHERE post_type = 'product'
                "
                        );
                        update_option('myfirstplugin_all_draft_posts', $mytestdrafts);
                    } else if (get_option('myfirstplugin_all_draft_posts')) {
                        $mytestdrafts = get_option('myfirstplugin_all_draft_posts');
                    }
                    ?>
                    <?php if ($mytestdrafts != "") {
                        foreach ($mytestdrafts as $mytestdraft) {
                            $id = $mytestdraft->ID;
                            $post_title = $mytestdraft->post_title;

                            ?>
                            <tr>
                                <td>
                                    <a href="<?php echo admin_url('options-general.php?page=change_text&id=' . $id . '&title=' . $post_title ); ?>"><?php echo $mytestdraft->post_title; ?></a>
                                </td>

                                <td><?php echo $mytestdraft->ID; ?></td>


                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>

                </table>
            </form>
        </div>
        <?php


    }
}

?>






