<?php
/**
 * Course evaluation listing markup
 */

defined( 'ABSPATH' ) || exit;

use Tutor_Periscope\Evaluation\Course_Evaluation_List_Table;
?>
<div class="wrap">
    <h2><?php esc_html_e( 'Course Evaluations', 'tutor-periscope' ); ?> <a href="<?php echo admin_url( 'admin.php?page=course-evaluation&action=new' ); ?>" class="add-new-h2"><?php esc_html_e( 'Add New', 'tutor-periscope' ); ?></a></h2>

    <form method="post">
        <input type="hidden" name="page" value="evaluation_list_table">

        <?php
        $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
        $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
        
        printf( '<input type="hidden" name="page" value="%s" />', $page );
        printf( '<input type="hidden" name="paged" value="%d" />', $paged );
        $list_table = new Course_Evaluation_List_Table();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>