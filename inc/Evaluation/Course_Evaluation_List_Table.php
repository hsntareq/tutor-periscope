<?php
/**
 * Course Evaluation List Table
 * 
 * @package Tutor Periscope
 */

namespace Tutor_Periscope\Evaluation;
use \WP_List_Table;

defined( 'ABSPATH' ) || exit;

/**
 * Evaluation List Table Class
 */
class Course_Evaluation_List_Table extends \WP_List_Table {

    public function __construct() {
        parent::__construct( array(
            'singular' => 'Course Evaluation',
            'plural'   => 'Course Evaluations',
            'ajax'     => false
        ) );
    }

    public function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    public function no_items() {
        _e( 'No course evaluations found', 'tutor-periscope' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    public function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'course_title':
                return $item->periscope_course_name;
                break;

            case 'course_code':
                return $item->periscope_course_code;
                break;

            case 'evaluation_date':
                return $item->created_at;
                break;

            case 'details':
                return sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=course-evaluation&action=view&id=' . $item->id ), $item->id, __( 'Details', 'tutor-periscope' ), __( 'View Details', 'tutor-periscope' ) );
                break;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
                break;
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    public function get_columns() {
        $columns = array(
            'cb'              => '<input type="checkbox" />',
            'course_title'    => __( 'Course Title', 'tutor-periscope' ),
            'course_code'     => __( 'Course Code', 'tutor-periscope' ),
            'evaluation_date' => __( 'Evaluation Date', 'tutor-periscope' ),
            'details'         => __( 'Details', 'tutor-periscope' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    public function column_course_title( $item ) {

        $actions           = array();
        $actions['view']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=course-evaluation&action=view&id=' . $item->id ), $item->id, __( 'View this item', 'tutor-periscope' ), __( 'View', 'tutor-periscope' ) );
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=course-evaluation&action=edit&id=' . $item->id ), $item->id, __( 'Edit this item', 'tutor-periscope' ), __( 'Edit', 'tutor-periscope' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=course-evaluation&action=delete&id=' . $item->id ), $item->id, __( 'Delete this item', 'tutor-periscope' ), __( 'Delete', 'tutor-periscope' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=course-evaluation&action=view&id=' . $item->id ), $item->periscope_course_name, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array( 'name', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
            'delete'  => __( 'Delete', 'tutor-periscope' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    public function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="Course Evaluation_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=course-evaluation' );

        foreach ( $this->counts as $key => $value ) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Process bulk actions
     */
    public function process_bulk_actions() {

        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'You don\'t have permission to perform this action!' );

        }

        if ( 'delete' === $this->current_action() ) {
            if ( isset( $_POST['Course_Evaluation_id'] ) && is_array( $_POST['Course_Evaluation_id'] ) ) {
                foreach ( $_POST['Course_Evaluation_id'] as $evaluation_id ) {
                    periscope_delete_course_evaluation( $evaluation_id );
                }
            }
        }
    }

    /**
     * Delete single entry
     *
     * @return void
     */
    public function delete_single_evaluation() {
        $single_evaluation_id = isset( $_GET['id'] ) && 'delete' === $_GET['action'] ? absint( $_GET['id'] ) : 0;
        periscope_delete_course_evaluation( $single_evaluation_id );
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    public function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->process_bulk_actions();
        $this->delete_single_evaluation();

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page - 1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only necessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items  = periscope_get_all_course_evaluation( $args );

        $this->set_pagination_args( array(
            'total_items' => periscope_get_course_evaluation_count(),
            'per_page'    => $per_page
        ) );
    }
}