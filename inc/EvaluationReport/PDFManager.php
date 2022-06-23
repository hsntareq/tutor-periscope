<?php
/**
 * Manage PDF view/download
 *
 * @since v2.0.0
 *
 * @package TutorPeriscope\EvaluationReport
 */

namespace Tutor_Periscope\EvaluationReport;

use Dompdf\Dompdf;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PDFManager {

	/**
	 * Render pdf
	 *
	 * @since v2.0.0
	 *
	 * @param string $content  content for rendering.
	 * @param string $file_name pdf file name.
	 * @param bool   $download  if false then it will show pdf.
	 *
	 * @return void
	 */
	public static function render( string $content, string $file_name, $download = false ): void {
		$html = ob_get_clean();
		// instantiate and use the dompdf class.
		$dompdf = new Dompdf();
		$dompdf->loadHtml( $content );
		// (Optional) Setup the paper size and orientation.
		$dompdf->setPaper( 'A4', 'landscape' );
		// Render the HTML as PDF.
		$dompdf->render();
		// Output the generated PDF to Browser.
		if ( false === $download ) {
			$dompdf->stream( $file_name, array( 'Attachment' => 0 ) );
		} else {
			$dompdf->stream( $file_name );
		}
	}
}
