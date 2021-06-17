<?php

if (!current_user_can('manage_options')) {
    wp_die(__('Sorry, you are not allowed to manage options for this site.'));
}

$change_text_id = $_GET['id'];
change_text_update_form($change_text_id);
function change_text_update_form($change_text_id)
{
    change_text_update($change_text_id);
    global $wpdb;
    if (get_option('change_text_all_posts')) {
        $change_text_result = get_option('change_text_all_posts');
    }
    if ($change_text_id) {
        foreach ($change_text_result as $change_text_cols) {
            $id = $change_text_cols->ID;
            if ($id = $change_text_id) {
                $change_text_title = $_GET['post_title'];
            }
        }
    }
}


function change_text_update($change_text_id)
{
    //update the records
    global $wpdb;

    $table_name = $wpdb->prefix . 'posts';

    $post_title = $_REQUEST['inputposttitle'];

    if(isset($_POST['update']))
    {
        // check to see if any text boxes are empty
        if(empty($post_title))
        {
            //remind users to fill out all the textboxes.
            echo "Please fill out the Post textbox. <br/><br/>";
        }
        else
        {
            $wpdb->update($table_name,
                array(
                    //These names are being pulled from the table.
                    'post_title' => $post_title,
                ),
                array(
                    'id' => $change_text_id     // where clause
                ) );

            echo "The record was been updated. <br/><br/>";
            $mytestdrafts = $wpdb->get_results(
                "
					SELECT ID, post_title
					FROM $wpdb->posts
					WHERE post_status = 'draft' and post_type = 'post'
					"
            );
            update_option('change_text_all_draft_posts', $mytestdrafts);
            echo '<script>window.location="admin.php?page=change_text"</script>';
        }

    } //end of if

} //end of function
?>


    <form action="" method="post">
        <div class="wrap">
            <label>Update the records and click Update button.</label>
            <br /><br />
            <table class="widefat">
                <tr>
                    <th>Post Title</th>
                    <th>Post ID</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><input class="input" type="text" name="inputposttitle" value="<?php echo $change_text_title;  ?>" /></td>
                    <td><label><?php echo $id; ?></label></td>
                    <td><button type="submit" name="update" class="button-primary">Update</button></td>
                </tr>
            </table>
        </div>
    </form>

<?php